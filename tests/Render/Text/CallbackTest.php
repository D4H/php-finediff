<?php

namespace FineDiff\Tests\Render\Text;

use FineDiff\Render\RendererInterface;
use FineDiff\Render\Text;
use PHPUnit\Framework\TestCase;

class CallbackTest extends TestCase
{
	/**
	 * @var RendererInterface
	 */
	protected $text;

	public function setUp(): void
	{
		$this->text = new Text();
	}

	public function testCopy(): void
	{
		$output = $this->text->callback('c', 'Hello', 0, 5);
		self::assertEquals($output, 'Hello');

		$output = $this->text->callback('c', 'Hello', 0, 3);
		self::assertEquals($output, 'Hel');
	}

	public function testDelete(): void
	{
		$output = $this->text->callback('d', 'elephant', 0, 100);
		self::assertEquals($output, '');

		$output = $this->text->callback('d', 'elephant', 3, 4);
		self::assertEquals($output, '');
	}

	public function testInsert(): void
	{
		$output = $this->text->callback('i', 'monkey', 0, 6);
		self::assertEquals($output, 'monkey');

		$output = $this->text->callback('i', 'monkey', 2, 3);
		self::assertEquals($output, 'nke');
	}
}
