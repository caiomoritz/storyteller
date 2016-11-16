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

namespace Storyteller\Expectation;

use Storyteller\Matcher\MatcherInterface;
use Storyteller\Util\Counter;

class ExpectationProxy implements ExpectationInterface
{
    /** @val Expectation */
    protected $expectation;

    /** @val Counter */
    protected $assertionsCounter;

    public function __construct(Expectation $expectation, Counter $assertionsCounter)
    {
        $this->expectation = $expectation;
        $this->assertionsCounter = $assertionsCounter;
    }

    /**
     * @param MatcherInterface $matcher
     */
    public function to(MatcherInterface $matcher)
    {
        $this->assertionsCounter->increment();
        return $this->expectation->to($matcher);
    }

    /**
     * @param MatcherInterface $matcher
     */
    public function notTo(MatcherInterface $matcher)
    {
        $this->assertionsCounter->increment();
        return $this->expectation->notTo($matcher);
    }
}
