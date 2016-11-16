<?php

namespace Storyteller\Tests\Matcher;

use Storyteller\Matcher\BeTrue;

class BeTrueTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldReturnTrueOnTrueValue()
    {
        $this->assertTrue((new BeTrue())->match(true));
    }

    public function testShouldReturnFalseOnNotTrueValue()
    {
        $this->assertFalse((new BeTrue())->match(false));
    }

    public function testErrorMessageShouldResembleDsl()
    {
        $this->assertEquals(
            'Expected <false> to be <true>',
            (new BeTrue())->errorString(false));
    }

    public function testNegationErrorMessageShouldResembleDsl()
    {
        $this->assertEquals(
            'Expected <false> not to be <true>',
            (new BeTrue())->negationErrorString(false));
    }
}
