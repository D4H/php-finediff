<?php

namespace FineDiff\Tests\Diff;

use FineDiff\Granularity\Character;
use FineDiff\Parser\OperationCodesInterface;
use FineDiff\Parser\ParserInterface;
use FineDiff\Render\Html;
use Mockery as m;
use FineDiff\Diff;
use PHPUnit\Framework\TestCase;

class DependencyInjectTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    public function testGetGranularity()
    {
        $character = m::mock(Character::class);

        $diff = new Diff($character);
        $granularity = $diff->getGranularity();

        $this->assertInstanceOf(Character::class, $granularity);
    }

    public function testGetRenderer()
    {
        $html = m::mock(Html::class);

        $diff = new Diff(null, $html);
        $renderer = $diff->getRenderer();

        $this->assertInstanceOf(Html::class, $renderer);
    }

    public function testRender()
    {
        $operation_codes = m::mock(OperationCodesInterface::class);
        $operation_codes->shouldReceive('generate')->andReturn('c12');

        $parser = m::mock(ParserInterface::class);
        $parser->shouldReceive('parse')->andReturn($operation_codes);

        $html = m::mock(Html::class);
        $html->shouldReceive('process')->with('hello', $operation_codes)->once();

        $diff = new Diff(null, $html, $parser);
        $diff->render('hello', 'hello2');

        $this->assertTrue(true);
    }

    public function testGetParser()
    {
        $parser = m::mock(ParserInterface::class);

        $diff = new Diff(null, null, $parser);
        $parser = $diff->getParser();

        $this->assertInstanceOf(ParserInterface::class, $parser);
    }

    public function testGetOperationCodes()
    {
        $parser = m::mock(ParserInterface::class);
        $parser->shouldReceive('parse')->with('foobar', 'eggfooba')->once();

        $diff = new Diff(null, null, $parser);
        $diff->getOperationCodes('foobar', 'eggfooba');

        $this->assertTrue(true);
    }
}
