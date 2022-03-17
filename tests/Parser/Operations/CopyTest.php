<?php

namespace FineDiff\Tests\Parser\Operations;

use FineDiff\Parser\Operations\Copy;
use FineDiff\Parser\Operations\OperationInterface;
use PHPUnit\Framework\TestCase;

class CopyTest extends TestCase
{
    public function testImplementsOperationInterface(): void
    {
        $replace = new Copy(10);
    }

    public function testGetFromLen(): void
    {
        $copy = new Copy(10);
	self::assertEquals($copy->getFromLen(), 10);
    }

    public function testGetToLen(): void
    {
        $copy = new Copy(342);
	self::assertEquals($copy->getToLen(), 342);
    }

    public function testGetOperationCode(): void
    {
        $copy = new Copy(1);
	self::assertEquals($copy->getOperationCode(), 'c');

        $copy = new Copy(24);
	self::assertEquals($copy->getOperationCode(), 'c24');
    }

    public function testIncrease(): void
    {
        $copy = new Copy(25);

	self::assertEquals($copy->increase(5), 30);
	self::assertEquals($copy->increase(10), 40);
	self::assertEquals($copy->increase(64), 104);
    }
}
