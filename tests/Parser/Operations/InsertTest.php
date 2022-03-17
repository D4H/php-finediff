<?php

namespace FineDiff\Tests\Parser\Operations;

use FineDiff\Parser\Operations\Insert;
use FineDiff\Parser\Operations\OperationInterface;
use PHPUnit\Framework\TestCase;

class InsertTest extends TestCase
{
    public function testGetFromLen(): void
    {
        $insert = new Insert('hello world');
	self::assertEquals($insert->getFromLen(), 0);
    }

    public function testGetToLen(): void
    {
        $insert = new Insert('hello world');
	self::assertEquals($insert->getToLen(), 11);
    }

    public function testGetText(): void
    {
        $insert = new Insert('foobar');
	self::assertEquals($insert->getText(), 'foobar');
    }

    public function testGetOperationCode(): void
    {
        $insert = new Insert('C');
	self::assertEquals($insert->getOperationCode(), 'i:C');

        $insert = new Insert('blue');
	self::assertEquals($insert->getOperationCode(), 'i4:blue');
    }
}
