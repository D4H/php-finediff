<?php

namespace FineDiff\Tests\Parser\Operations;

use FineDiff\Parser\Operations\Delete;
use FineDiff\Parser\Operations\OperationInterface;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase
{
    public function testImplementsOperationInterface()
    {
        $replace = new Delete(10);
        $this->assertInstanceOf(OperationInterface::class, $replace);
    }

    public function testGetFromLen()
    {
        $delete = new Delete(10);
        $this->assertEquals($delete->getFromLen(), 10);
    }

    public function testGetToLen()
    {
        $delete = new Delete(342);
        $this->assertEquals($delete->getToLen(), 0);
    }

    public function testGetOperationCode()
    {
        $delete = new Delete(1);
        $this->assertEquals($delete->getOperationCode(), 'd');

        $delete = new Delete(24);
        $this->assertEquals($delete->getOperationCode(), 'd24');
    }
}
