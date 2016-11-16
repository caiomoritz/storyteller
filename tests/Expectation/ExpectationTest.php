<?php

namespace Storyteller\Tests\Expectation;

use Storyteller\Expectation\Expectation;
use Storyteller\Expectation\InvalidExpectationException;
use Storyteller\Matcher\Equal;

class ExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testTo_ShouldNotThrowExceptionOnValidExpectation()
    {
        $this->assertNull((new Expectation("Storyteller"))->to((new Equal("Storyteller"))));
    }

    /**
     * @expectedException Storyteller\Expectation\InvalidExpectationException
     */
    public function testTo_ShouldThrowExceptionOnInvalidExpectation()
    {
        (new Expectation("Storyteller"))->to((new Equal("...")));
    }

    public function testNotTo_ShouldNotThrowExceptionOnValidExpectation()
    {
        $this->assertNull((new Expectation("Storyteller"))->notTo((new Equal("..."))));
    }

    /**
     * @expectedException Storyteller\Expectation\InvalidExpectationException
     */
    public function testNotTo_ShouldThrowExceptionOnInvalidExpectation()
    {
        (new Expectation("Storyteller"))->notTo((new Equal("Storyteller")));
    }
}
