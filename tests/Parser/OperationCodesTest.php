<?php

namespace FineDiff\Tests\Parser;

use FineDiff\Exceptions\OperationException;
use FineDiff\Parser\OperationCodes;
use FineDiff\Parser\OperationCodesInterface;
use FineDiff\Parser\Operations\Copy;
use FineDiff\Parser\Operations\OperationInterface;
use Mockery as m;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class OperationCodesTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    public function testEmptyOperationCodes(): void
    {
        $operation_codes = new OperationCodes();
	self::assertEmpty($operation_codes->getOperationCodes());
    }

    public function testSetOperationCodes(): void
    {
        $operation = m::mock(OperationInterface::class);
        $operation->shouldReceive('getOperationCode')->once()->andReturn('testing');

        $operation_codes = new OperationCodes();
        $operation_codes->setOperationCodes([$operation]);

        $operation_codes = $operation_codes->getOperationCodes();
	self::assertEquals($operation_codes[0], 'testing');
    }

    public function testGetOperationCodes(): void
    {
        $operation_one = m::mock(Copy::class);
        $operation_one->shouldReceive('getOperationCode')->andReturn('c5i');

        $operation_two = m::mock(Copy::class);
        $operation_two->shouldReceive('getOperationCode')->andReturn('2c6d');

        $operation_codes = new OperationCodes();
        $operation_codes->setOperationCodes([$operation_one, $operation_two]);

        $operation_codes = $operation_codes->getOperationCodes();

	self::assertEquals($operation_codes[0], 'c5i');
	self::assertEquals($operation_codes[1], '2c6d');
    }

    public function testGenerate(): void
    {
        $operation_one = m::mock(Copy::class);
        $operation_one->shouldReceive('getOperationCode')->andReturn('c5i');

        $operation_two = m::mock(Copy::class);
        $operation_two->shouldReceive('getOperationCode')->andReturn('2c6d');

        $operation_codes = new OperationCodes();
        $operation_codes->setOperationCodes([$operation_one, $operation_two]);

	self::assertEquals($operation_codes->generate(), 'c5i2c6d');
    }

    public function testToString(): void
    {
        $operation_one = m::mock(Copy::class);
        $operation_one->shouldReceive('getOperationCode')->andReturn('c5i');

        $operation_two = m::mock(Copy::class);
        $operation_two->shouldReceive('getOperationCode')->andReturn('2c6d');

        $operation_codes = new OperationCodes();
        $operation_codes->setOperationCodes([$operation_one, $operation_two]);

	self::assertEquals((string)$operation_codes, 'c5i2c6d');
	self::assertEquals((string)$operation_codes, $operation_codes->generate());
    }
}
