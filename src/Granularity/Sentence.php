<?php

namespace FineDiff\Granularity;

use FineDiff\Delimiters;

class Sentence implements GranularityInterface
{
	use Granularity;

	/**
	 * @var string[]
	 */
	private $delimiters = [
		Delimiters::PARAGRAPH,
		Delimiters::SENTENCE,
	];
}
