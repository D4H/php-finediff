<?php

namespace FineDiff\Tests\Parser\Operations;

use FineDiff\Parser\Operations\Delete;
use FineDiff\Parser\Operations\OperationInterface;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase
{
    public function testGetFromLen(): void
    {
        $delete = new Delete(10);
	self::assertEquals($delete->getFromLen(), 10);
    }

    public function testGetToLen(): void
    {
        $delete = new Delete(342);
	self::assertEquals($delete->getToLen(), 0);
    }

    public function testGetOperationCode(): void
    {
        $delete = new Delete(1);
	self::assertEquals($delete->getOperationCode(), 'd');

        $delete = new Delete(24);
	self::assertEquals($delete->getOperationCode(), 'd24');
    }
}
