<?php

namespace FineDiff\Granularity;

use FineDiff\Delimiters;

class Paragraph implements GranularityInterface
{
	use Granularity;

	/**
	 * @var string[]
	 */
	private $delimiters = [
		Delimiters::PARAGRAPH,
	];
}
