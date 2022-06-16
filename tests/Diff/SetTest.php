<?php

namespace FineDiff\Tests\Diff;

use FineDiff\Diff;
use FineDiff\Granularity\GranularityInterface;
use FineDiff\Parser\ParserInterface;
use FineDiff\Render\Html;
use Mockery as m;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
	/**
	 * @var Diff
	 */
	protected $diff;

	public function setUp(): void
	{
		$this->diff = new Diff();
	}

	public function tearDown(): void
	{
		m::close();
	}

	public function testSetParser(): void
	{
		self::assertFalse(method_exists($this->diff->getParser(), 'fooBar'));

		/**
		 * @var ParserInterface|MockInterface $parser
		 */
		$parser = m::mock(ParserInterface::class);
		$parser->shouldReceive('fooBar')->once();

		$this->diff->setParser($parser);
		$parser = $this->diff->getParser();

		$parser->fooBar();
	}

	public function testSetRenderer(): void
	{
		self::assertFalse(method_exists($this->diff->getRenderer(), 'fooBar'));

		/**
		 * @var Html|MockInterface $html
		 */
		$html = m::mock(Html::class);
		$html->shouldReceive('fooBar')->once();

		$this->diff->setRenderer($html);
		$html = $this->diff->getRenderer();

		$html->fooBar();
	}

	public function testSetGranularity(): void
	{
		self::assertFalse(method_exists($this->diff->getGranularity(), 'fooBar'));

		/**
		 * @var GranularityInterface|MockInterface $granularity
		 */
		$granularity = m::mock(GranularityInterface::class);
		$granularity->shouldReceive('fooBar')->once();

		$parser = m::mock(ParserInterface::class);
		$parser->shouldReceive('setGranularity')->with($granularity)->once();
		$parser->shouldReceive('getGranularity')->andReturn($granularity)->once();

		$this->diff->setParser($parser);
		$this->diff->setGranularity($granularity);

		$granularity = $this->diff->getGranularity();
		$granularity->fooBar();
	}
}
