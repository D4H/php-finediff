<?php

namespace FineDiff\Granularity;

trait Granularity
{
	/**
	 * @inheritdoc
	 */
	public function offsetExists($offset): bool
	{
		return isset($this->delimiters[$offset]);
	}

	/**
	 * @inheritdoc
	 */
	public function offsetGet($offset): mixed
	{
		return isset($this->delimiters[$offset]) ? $this->delimiters[$offset] : null;
	}

	/**
	 * @inheritdoc
	 */
	public function offsetSet($offset, $value): void
	{
		if (!is_string($value)) {
			return;
		}

		if ($offset === null) {
			$this->delimiters[] = $value;
		} else {
			$this->delimiters[$offset] = $value;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function offsetUnset($offset): void
	{
		unset($this->delimiters[$offset]);
	}

	/**
	 * Return the number of delimiters this granularity contains.
	 *
	 */
	public function count(): int
	{
		return count($this->delimiters);
	}

	/**
	 * @inheritdoc
	 * @return string[]
	 */
	public function getDelimiters(): array
	{
		return $this->delimiters;
	}

	/**
	 * @inheritdoc
	 * @param string[] $delimiters
	 */
	public function setDelimiters(array $delimiters): void
	{
		$this->delimiters = $delimiters;
	}
}
