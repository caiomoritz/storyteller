<?php

namespace Storyteller\Tests\Matcher;

use Storyteller\Matcher\Equal;

class EqualTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldReturnTrueOnEquality()
    {
        $this->assertTrue((new Equal("Storyteller"))->match("Storyteller"));
    }

    public function testShouldReturnFalseOnInequality()
    {
        $this->assertFalse((new Equal("Storyteller"))->match("foo"));
    }

    public function testErrorMessageShouldResembleDsl()
    {
        $this->assertEquals(
            'Expected "foo" to equal "Storyteller"',
            (new Equal("Storyteller"))->errorString('foo'));
    }

    public function testNegationErrorMessageShouldResembleDsl()
    {
        $this->assertEquals(
            'Expected "foo" not to equal "Storyteller"',
            (new Equal("Storyteller"))->negationErrorString('foo'));
    }
}
