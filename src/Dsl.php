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

use Storyteller\StoryBlock\StoryBlockFactory;
use Storyteller\StoryBlock\StoryBlockInterface;
use Storyteller\Expectation\Expectation;
use Storyteller\Expectation\ExpectationInterface;
use Storyteller\Expectation\ExpectationProxy;
use Storyteller\Expectation\InvalidExpectationException;

function describe(string $description, \Closure $body)
{
    Storyteller::instance()->addStoryBlock(Storyteller::DESCRIBE, $description, $body);
}

function context(string $description, \Closure $body)
{
    Storyteller::instance()->addStoryBlock(Storyteller::CONTEXT, $description, $body);
}

function should(string $description, \Closure $body)
{
    Storyteller::instance()->addStoryBlock(Storyteller::SHOULD, $description, $body);
}

function expect($val): ExpectationInterface
{
    return new ExpectationProxy(new Expectation($val), Storyteller::instance()->getAssertionsCounter());
}
