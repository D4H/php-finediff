<?php

namespace FineDiff\Tests\Parser;

use FineDiff\Exceptions\GranularityCountException;
use FineDiff\Parser\OperationCodesInterface;
use FineDiff\Granularity\Character;
use FineDiff\Parser\Parser;
use FineDiff\Parser\ParserInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @var ParserInterface
     */
    protected $parser;

    public function setUp(): void
    {
        $granularity  = new Character();
        $this->parser = new Parser($granularity);
    }

    public function tearDown(): void
    {
        m::close();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf(ParserInterface::class, $this->parser);
    }

    public function testDefaultOperationCodes()
    {
        $operation_codes = $this->parser->getOperationCodes();
        $this->assertInstanceOf(OperationCodesInterface::class, $operation_codes);
    }

    public function testSetOperationCodes()
    {
        $operation_codes = m::mock(OperationCodesInterface::class);
        $operation_codes->shouldReceive('foo')->andReturn('bar');
        $this->parser->setOperationCodes($operation_codes);

        $operation_codes = $this->parser->getOperationCodes();
        $this->assertEquals($operation_codes->foo(), 'bar');
    }

    public function testParseBadGranularity()
    {
        $granularity = m::mock(Character::class);
        $granularity->shouldReceive('count')->andReturn(0);
        $parser = new Parser($granularity);

        $this->expectException(GranularityCountException::class);

        $parser->parse('hello world', 'hello2 worl');
    }

    public function testParseSetOperationCodes()
    {
        $operation_codes = m::mock(OperationCodesInterface::class);
        $operation_codes->shouldReceive('setOperationCodes')->once();
        $this->parser->setOperationCodes($operation_codes);

        $this->parser->parse('Hello worlds', 'Hello2 world');

        $this->assertTrue(true);
    }
}
