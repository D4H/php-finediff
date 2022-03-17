<?php

namespace FineDiff\Tests\Diff;

use FineDiff\Granularity\Character;
use FineDiff\Parser\OperationCodesInterface;
use FineDiff\Parser\ParserInterface;
use FineDiff\Render\Html;
use Mockery as m;
use FineDiff\Diff;
use PHPUnit\Framework\TestCase;
use Mockery\MockInterface;

class DependencyInjectTest extends TestCase
{
	public function tearDown(): void
	{
		m::close();
	}

	public function testGetGranularity(): void
	{
		/**
		 * @var Character|MockInterface $character
		 */
		$character = m::mock(Character::class);

		$diff = new Diff($character);
		$granularity = $diff->getGranularity();

		self::assertInstanceOf(Character::class, $granularity);
	}

	public function testGetRenderer(): void
	{
		$html = m::mock(Html::class);

		$diff = new Diff(null, $html);
		$renderer = $diff->getRenderer();

		self::assertInstanceOf(Html::class, $renderer);
	}

	public function testRender(): void
	{
		/**
		 * @var OperationCodesInterface|MockInterface $operation_codes
		 */
		$operation_codes = m::mock(OperationCodesInterface::class);
		$operation_codes->shouldReceive('generate')->andReturn('c12');

		/**
		 * @var ParserInterface|MockInterface $parser
		 */
		$parser = m::mock(ParserInterface::class);
		$parser->shouldReceive('parse')->andReturn($operation_codes);

		/**
		 * @var Html|MockInterface $html
		 */
		$html = m::mock(Html::class);
		$html->shouldReceive('process')->with('hello', $operation_codes)->once();

		$diff = new Diff(null, $html, $parser);
		$diff->render('hello', 'hello2');
	}

	public function testGetParser(): void
	{
		/**
		 * @var ParserInterface|MockInterface $parser
		 */
		$parser = m::mock(ParserInterface::class);

		$diff = new Diff(null, null, $parser);
		$parser = $diff->getParser();
	}

	public function testGetOperationCodes(): void
	{
		/**
		 * @var ParserInterface|MockInterface $parser
		 */
		$parser = m::mock(ParserInterface::class);
		$parser->shouldReceive('parse')->with('foobar', 'eggfooba')->once();

		$diff = new Diff(null, null, $parser);
		$diff->getOperationCodes('foobar', 'eggfooba');
	}
}
