<?php

namespace FineDiff\Granularity;

use ArrayAccess;
use Countable;

/**
 * @extends ArrayAccess<int,string|null>
 */
interface GranularityInterface extends ArrayAccess, Countable
{
	/**
	 * Get the delimiters that make up the granularity.
	 *
	 * @return string[]
	 */
	public function getDelimiters(): array;

	/**
	 * Set the delimiters that make up the granularity.
	 *
	 * @param string[] $delimiters
	 * @return void
	 */
	public function setDelimiters(array $delimiters);
}
