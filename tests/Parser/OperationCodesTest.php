<?php

namespace FineDiff\Tests\Parser;

use FineDiff\Exceptions\OperationException;
use FineDiff\Parser\OperationCodes;
use FineDiff\Parser\OperationCodesInterface;
use FineDiff\Parser\Operations\Copy;
use FineDiff\Parser\Operations\OperationInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class OperationCodesTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf(OperationCodesInterface::class, new OperationCodes());
    }

    public function testEmptyOperationCodes()
    {
        $operation_codes = new OperationCodes();
        $this->assertEmpty($operation_codes->getOperationCodes());
    }

    public function testSetOperationCodes()
    {
        $operation = m::mock(OperationInterface::class);
        $operation->shouldReceive('getOperationCode')->once()->andReturn('testing');

        $operation_codes = new OperationCodes();
        $operation_codes->setOperationCodes([$operation]);

        $operation_codes = $operation_codes->getOperationCodes();
        $this->assertEquals($operation_codes[0], 'testing');
    }

    public function testNotOperation()
    {
        $operation_codes = new OperationCodes();

        $this->expectException(OperationException::class);

        $operation_codes->setOperationCodes(['test']);
    }

    public function testGetOperationCodes()
    {
        $operation_one = m::mock(Copy::class);
        $operation_one->shouldReceive('getOperationCode')->andReturn('c5i');

        $operation_two = m::mock(Copy::class);
        $operation_two->shouldReceive('getOperationCode')->andReturn('2c6d');

        $operation_codes = new OperationCodes();
        $operation_codes->setOperationCodes([$operation_one, $operation_two]);

        $operation_codes = $operation_codes->getOperationCodes();

        $this->assertIsArray($operation_codes);
        $this->assertEquals($operation_codes[0], 'c5i');
        $this->assertEquals($operation_codes[1], '2c6d');
    }

    public function testGenerate()
    {
        $operation_one = m::mock(Copy::class);
        $operation_one->shouldReceive('getOperationCode')->andReturn('c5i');

        $operation_two = m::mock(Copy::class);
        $operation_two->shouldReceive('getOperationCode')->andReturn('2c6d');

        $operation_codes = new OperationCodes();
        $operation_codes->setOperationCodes([$operation_one, $operation_two]);

        $this->assertEquals($operation_codes->generate(), 'c5i2c6d');
    }

    public function testToString()
    {
        $operation_one = m::mock(Copy::class);
        $operation_one->shouldReceive('getOperationCode')->andReturn('c5i');

        $operation_two = m::mock(Copy::class);
        $operation_two->shouldReceive('getOperationCode')->andReturn('2c6d');

        $operation_codes = new OperationCodes();
        $operation_codes->setOperationCodes([$operation_one, $operation_two]);

        $this->assertEquals((string)$operation_codes, 'c5i2c6d');
        $this->assertEquals((string)$operation_codes, $operation_codes->generate());
    }
}
