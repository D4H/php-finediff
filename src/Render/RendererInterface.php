<?php

namespace FineDiff\Render;

use FineDiff\Parser\OperationCodesInterface;

interface RendererInterface
{
	/**
	 * Covert text based on the provided operation codes.
	 *
	 *
	 */
	public function process(string $fromText, string|OperationCodesInterface $operationCodes): string;

	/**
	 *
	 */
	public function callback(string $opcode, string $from, int $offset, int $length): string;
}
