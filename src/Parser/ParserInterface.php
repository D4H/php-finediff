<?php

namespace FineDiff\Parser;

use FineDiff\Exceptions\GranularityCountException;
use FineDiff\Granularity\GranularityInterface;

interface ParserInterface
{
	/**
	 * Creates an instance.
	 *
	 */
	public function __construct(GranularityInterface $granularity);

	/**
	 * Granularity the parser is working with.
	 *
	 */
	public function getGranularity(): GranularityInterface;

	/**
	 * Set the granularity that the parser is working with.
	 *
	 */
	public function setGranularity(GranularityInterface $granularity): void;

	/**
	 * Get the operation codes object that is used to store all the operation codes.
	 *
	 */
	public function getOperationCodes(): OperationCodesInterface;

	/**
	 * Set the operation codes object used to store all the operation codes for this parse.
	 *
	 *
	 */
	public function setOperationCodes(OperationCodesInterface $operationCodes): void;

	/**
	 * Generates the operation codes needed to transform one string to another.
	 *
	 * @param string $fromText
	 * @param string $toText
	 *
	 *@throws GranularityCountException
	 */
	public function parse($fromText, $toText): OperationCodesInterface;
}
