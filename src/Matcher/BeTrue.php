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

namespace Storyteller\Matcher;

class BeTrue implements MatcherInterface
{
    public function match($val): bool
    {
        return true === $val;
    }

    public function errorString($val): string
    {
        $stringVal = ($val) ? 'true' : 'false';
        return sprintf('Expected <%s> to be <true>', $stringVal);
    }

    public function negationErrorString($val): string
    {
        $stringVal = ($val) ? 'true' : 'false';
        return sprintf('Expected <%s> not to be <true>', $stringVal);
    }
}
