<?php

namespace FineDiff\Tests\Parser\Operations;

use FineDiff\Parser\Operations\OperationInterface;
use FineDiff\Parser\Operations\Replace;
use PHPUnit\Framework\TestCase;

class ReplaceTest extends TestCase
{
    public function testImplementsOperationInterface()
    {
        $replace = new Replace('hello', 'world');
        $this->assertInstanceOf(OperationInterface::class, $replace);
    }

    public function testGetFromLen()
    {
        $replace = new Replace('hello', 'world');
        $this->assertEquals($replace->getFromLen(), 'hello');
    }

    public function testGetToLen()
    {
        $replace = new Replace('hello', 'world');
        $this->assertEquals($replace->getToLen(), 5);
    }

    public function testGetText()
    {
        $replace = new Replace('foo', 'bar');
        $this->assertEquals($replace->getText(), 'bar');
    }

    public function testGetOperationCodeSingleTextChar()
    {
        $replace = new Replace(1, 'c');
        $this->assertEquals($replace->getOperationCode(), 'di:c');

        $replace = new Replace('r', 'c');
        $this->assertEquals($replace->getOperationCode(), 'dri:c');

        $replace = new Replace('rob', 'c');
        $this->assertEquals($replace->getOperationCode(), 'drobi:c');
    }

    public function testGetOpcodeLongerTextString()
    {
        $replace = new Replace(1, 'crowe');
        $this->assertEquals($replace->getOperationCode(), 'di5:crowe');

        $replace = new Replace('r', 'crowe');
        $this->assertEquals($replace->getOperationCode(), 'dri5:crowe');

        $replace = new Replace('rob', 'crowe');
        $this->assertEquals($replace->getOperationCode(), 'drobi5:crowe');
    }
}
