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

namespace Storyteller\Output;

class ColoredOutputWriter implements OutputWriterInterface
{
    /** @var OutputWriterInterface */
    private $writer;

    public function __construct(OutputWriterInterface $writer)
    {
        $this->writer = $writer;
    }

    public function write($message, array $context = [])
    {
        $this->writer->write($this->transform($message));
    }

    public function writeln($message = '', array $context = [])
    {
        $this->write($message . "\n");
    }

    private function transform($message): string
    {
        return strtr($message, [
            '<fmt fg=red>'   => "\033[1;31m",
            '<fmt bg=red>'   => "\033[0;41m",
            '<fmt bg=green>' => "\033[0;30;42m",
            '</fmt>'         => "\033[0m",
        ]);
    }
}
