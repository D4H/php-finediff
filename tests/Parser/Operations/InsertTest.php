<?php

namespace FineDiff\Tests\Parser\Operations;

use FineDiff\Parser\Operations\Insert;
use FineDiff\Parser\Operations\OperationInterface;
use PHPUnit\Framework\TestCase;

class InsertTest extends TestCase
{
    public function testImplementsOperationInterface()
    {
        $replace = new Insert('hello world');
        $this->assertInstanceOf(OperationInterface::class, $replace);
    }

    public function testGetFromLen()
    {
        $insert = new Insert('hello world');
        $this->assertEquals($insert->getFromLen(), 0);
    }

    public function testGetToLen()
    {
        $insert = new Insert('hello world');
        $this->assertEquals($insert->getToLen(), 11);
    }

    public function testGetText()
    {
        $insert = new Insert('foobar');
        $this->assertEquals($insert->getText(), 'foobar');
    }

    public function testGetOperationCode()
    {
        $insert = new Insert('C');
        $this->assertEquals($insert->getOperationCode(), 'i:C');

        $insert = new Insert('blue');
        $this->assertEquals($insert->getOperationCode(), 'i4:blue');
    }
}
