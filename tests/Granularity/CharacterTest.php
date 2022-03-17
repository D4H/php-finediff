<?php

namespace FineDiff\Tests\Granularity;

use FineDiff\Delimiters;
use FineDiff\Granularity\Character;
use FineDiff\Granularity\GranularityInterface;
use PHPUnit\Framework\TestCase;

class CharacterTest extends TestCase
{
	/**
	 */
	protected GranularityInterface $granularity;

	/**
	 * @var string[]
	 */
	protected $delimiters = [
		Delimiters::PARAGRAPH,
		Delimiters::SENTENCE,
		Delimiters::WORD,
		Delimiters::CHARACTER,
	];

	public function setUp(): void
	{
		$this->granularity = new Character();
	}

	public function testGetDelimiters(): void
	{
		self::assertEquals($this->granularity->getDelimiters(), $this->delimiters);
	}

	public function testSetDelimiters(): void
	{
		$arr = array('one', 'two');
		$this->granularity->setDelimiters($arr);
		self::assertEquals($this->granularity->getDelimiters(), $arr);
	}

	public function testCountable(): void
	{
		self::assertCount(count($this->granularity), $this->delimiters);
	}

	public function testArrayAccess(): void
	{
		// Exists
		for ($i = 0; $i < count($this->delimiters) + 1; $i++) {
			if ($i !== count($this->delimiters)) {
				self::assertTrue(isset($this->granularity[$i]));
			} else {
				self::assertFalse(isset($this->granularity[$i]));
			}
		}

		// Get
		for ($i = 0; $i < count($this->delimiters) + 1; $i++) {
			if ($i !== count($this->delimiters)) {
				self::assertEquals($this->granularity[$i], $this->delimiters[$i]);
			} else {
				self::assertNull($this->granularity[$i]);
			}
		}

		// Set
		for ($i = 0; $i < count($this->delimiters) + 1; $i++) {
			$rand = (string)mt_rand(0, 1000);

			$this->granularity[$i] = $rand;
			self::assertEquals($this->granularity[$i], $rand);
		}

		self::assertEquals(count($this->granularity), count($this->delimiters) + 1);

		// Unset
		unset($this->granularity[ count($this->delimiters) ]);
		self::assertCount(count($this->granularity), $this->delimiters);
	}
}
