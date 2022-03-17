<?php

namespace FineDiff\Render;

use FineDiff\Parser\OperationCodesInterface;

interface RendererInterface
{
    /**
     * Covert text based on the provided operation codes.
     *
     * @param string $fromText
     * @param string|OperationCodesInterface $operationCodes
     *
     * @return string
     */
    public function process(string $fromText, string|OperationCodesInterface $operationCodes): string;

    /**
     * @param string $opcode
     * @param string $from
     * @param int $offset
     * @param int $length
     *
     * @return string
     */
    public function callback(string $opcode, string $from, int $offset, int $length): string;
}
