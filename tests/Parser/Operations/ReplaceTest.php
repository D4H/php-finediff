<?php

namespace FineDiff\Tests\Parser\Operations;

use FineDiff\Parser\Operations\Replace;
use PHPUnit\Framework\TestCase;

class ReplaceTest extends TestCase
{
	public function testGetFromLen(): void
	{
		$replace = new Replace('hello', 'world');
		self::assertEquals($replace->getFromLen(), 'hello');
	}

	public function testGetToLen(): void
	{
		$replace = new Replace('hello', 'world');
		self::assertEquals($replace->getToLen(), 5);
	}

	public function testGetText(): void
	{
		$replace = new Replace('foo', 'bar');
		self::assertEquals($replace->getText(), 'bar');
	}

	public function testGetOperationCodeSingleTextChar(): void
	{
		$replace = new Replace(1, 'c');
		self::assertEquals($replace->getOperationCode(), 'di:c');

		$replace = new Replace('r', 'c');
		self::assertEquals($replace->getOperationCode(), 'dri:c');

		$replace = new Replace('rob', 'c');
		self::assertEquals($replace->getOperationCode(), 'drobi:c');
	}

	public function testGetOpcodeLongerTextString(): void
	{
		$replace = new Replace(1, 'crowe');
		self::assertEquals($replace->getOperationCode(), 'di5:crowe');

		$replace = new Replace('r', 'crowe');
		self::assertEquals($replace->getOperationCode(), 'dri5:crowe');

		$replace = new Replace('rob', 'crowe');
		self::assertEquals($replace->getOperationCode(), 'drobi5:crowe');
	}
}
