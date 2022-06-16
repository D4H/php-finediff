<?php

namespace FineDiff\Tests\Render\Text;

use FineDiff\Parser\OperationCodesInterface;
use FineDiff\Render\RendererInterface;
use FineDiff\Render\Text;
use InvalidArgumentException;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{
	/**
	 * @var RendererInterface
	 */
	protected $text;

	public function setUp(): void
	{
		$this->text = new Text();
	}

	public function tearDown(): void
	{
		m::close();
	}

	public function testInvalidOperationCode(): void
	{
		$this->expectException(InvalidArgumentException::class);

		$this->text->process('Hello worlds', (string)123);
	}

	public function testProcessWithString(): void
	{
		$html = $this->text->process('Hello worlds', 'c5i:2c6d');

		self::assertEquals($html, 'Hello2 world');
	}

	public function testProcess(): void
	{
		$operation_codes = m::mock(OperationCodesInterface::class);
		$operation_codes->shouldReceive('generate')->andReturn('c5i:2c6d')->once();

		$html = $this->text->process('Hello worlds', $operation_codes);

		self::assertEquals($html, 'Hello2 world');
	}
}
