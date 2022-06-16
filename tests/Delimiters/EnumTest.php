<?php

namespace FineDiff\Tests\Delimiters;

use FineDiff\Delimiters;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

class EnumTest extends TestCase
{
	public function testCantInstantiate(): void
	{
		$class = new ReflectionClass(Delimiters::class);
		$methods = $class->getMethods(ReflectionMethod::IS_PRIVATE);

		self::assertTrue(count($methods) >= 1);

		$found = false;

		$constructor = array_filter($methods, fn ($method) => $method->name === '__construct');
		self::assertEquals(1, count($constructor));
	}
}
