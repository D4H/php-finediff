<?php

namespace FineDiff\Parser;

use FineDiff\Exceptions\OperationException;
use FineDiff\Parser\Operations\OperationInterface;

interface OperationCodesInterface
{
	/**
	 * Get the operation codes.
	 *
	 * @return string[]
	 */
	public function getOperationCodes(): array;

	/**
	 * Set the operation codes for this parse.
	 *
	 * @param OperationInterface[] $operationCodes
	 *
	 * @throws OperationException
	 */
	public function setOperationCodes(array $operationCodes): void;

	/**
	 * Return the operation codes in a format that can then be rendered.
	 *
	 */
	public function generate(): string;

	/**
	 * When object is cast to a string returns operation codes as string.
	 *
	 * @see OperationCodes::generate
	 *
	 * @return string
	 */
	public function __toString();
}
