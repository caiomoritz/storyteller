<?php declare(strict_types=1);

// Copyright 2016 Caio Ronchi
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//   http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Storyteller;

use Storyteller\Finder\RecursiveRegexFileFinder;
use Storyteller\Expectation\InvalidExpectationException;
use Storyteller\Output\ColoredOutputWriter;
use Storyteller\Output\OutputWriterInterface;
use Storyteller\Output\StdoutWriter;
use Storyteller\Util\Counter;

class Storyteller
{
    const DESCRIBE = 'describe';
    const CONTEXT  = 'context';
    const SHOULD   = 'should';

    const STATE_NOT_RUNNING = 1;
    const STATE_RUNNING     = 2;

    /** @var RecursiveRegexFileFinder */
    private $storyFinder;

    /** @var OutputWriterInterface */
    private $writer;

    /** @var Counter */
    private $assertionsCounter;

    /** @var \Closure[] */
    private $storyBlocks;

    /** @var int */
    private $state;

    /** @var \InvalidExpectationException[] */
    private $invalidExpectations;

    /** @var Storyteller */
    private static $instance;

    private function __construct() {}

    public static function create(
        RecursiveRegexFileFinder $storyFinder,
        OutputWriterInterface $writer,
        Counter $assertionsCounter
    ): Storyteller
    {
        if (null == static::$instance) {
            static::$instance = new Storyteller();
            static::$instance->storyFinder = $storyFinder;
            static::$instance->writer = $writer;
            static::$instance->assertionsCounter = $assertionsCounter;
            static::$instance->storyBlocks = [];
            static::$instance->invalidExpectations = [];
        }

        return static::$instance;
    }

    public static function instance(): Storyteller
    {
        if (null == static::$instance) {
            throw new \RuntimeException('Storyteller::create() must be called first');
        }

        return static::$instance;
    }

    public function addStoryBlock(string $blockType, string $description, \Closure $body)
    {
        $storyBlock = function() use ($blockType, $body) {
            try {
                $body();
                if (Storyteller::SHOULD == $blockType) {
                    $this->writer->write('.');
                }
            } catch (InvalidExpectationException $e) {
                $this->writer->write('<fmt fg=red>E</fmt>');
                throw $e;
            }
        };

        if ($this->isRunning()) {
            $this->runStoryBlock($storyBlock);
            return;
        }

        $this->storyBlocks[] = $storyBlock;
    }

    public function run()
    {
        require_once __DIR__ . '/Dsl.php';
        require_once __DIR__ . '/Matcher/Dsl.php';

        $this->state = static::STATE_RUNNING;

        $this->writer->write("Storyteller 0.9.0 by Caio Ronchi.\n\n");

        foreach($this->storyFinder->find() as $path) {
            require_once $path;
        }

        foreach ($this->storyBlocks as $storyBlock) {
            $this->runStoryBlock($storyBlock);
        }

        $this->writer->writeln();
        foreach ($this->invalidExpectations as $invalidExpectation) {
            $this->writer->writeln(sprintf("\n=> %s in", $invalidExpectation->getMessage()));
            $trace = $invalidExpectation->getTrace()[1];
            $this->writer->writeln(sprintf("%s:%d", $trace['file'], $trace['line']));
        }
        $this->writer->writeln();

        $bgColor = (sizeof($this->invalidExpectations) == 0) ? 'green' : 'red';
        $this->writer->writeln(sprintf("<fmt bg={$bgColor}>%d assertion(s), %d error(s)</fmt>",
            $this->assertionsCounter->peek(),
            sizeof($this->invalidExpectations)
        ));

        $this->state = static::STATE_NOT_RUNNING;
    }

    private function runStoryBlock(\Closure $storyBlock)
    {
        try {
            $storyBlock();
        } catch (InvalidExpectationException $e) {
            $this->invalidExpectations[] = $e;
        }
    }

    private function isRunning(): bool
    {
        return static::STATE_RUNNING == $this->state;
    }

    public function getAssertionsCounter(): Counter
    {
        return $this->assertionsCounter;
    }
}
