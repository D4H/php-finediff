<?php

namespace FineDiff\Parser\Operations;

interface OperationInterface
{
	/**
	 * Copy code
	 *
	 * @var string
	 */
	public const COPY = 'c';

	/**
	 * Delete code
	 *
	 * @var string
	 */
	public const DELETE = 'd';

	/**
	 * Insert code
	 *
	 * @var string
	 */
	public const INSERT = 'i';

	/**
	 */
	public function getFromLen(): int|string;

	/**
	 */
	public function getToLen(): int;

	/**
	 * @return string Operation code for this operation.
	 */
	public function getOperationCode(): string;
}
