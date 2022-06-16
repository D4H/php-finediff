<?php

namespace FineDiff\Granularity;

use FineDiff\Delimiters;

class Character implements GranularityInterface
{
	use Granularity;

	/**
	 * @var string[] $delimiters
	 */
	private $delimiters = [
		Delimiters::PARAGRAPH,
		Delimiters::SENTENCE,
		Delimiters::WORD,
		Delimiters::CHARACTER,
	];
}
