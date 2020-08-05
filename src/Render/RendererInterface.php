<?php

namespace FineDiff\Render;

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
    public function process($fromText, $operationCodes): string;

    /**
     * @param string $opcode
     * @param string $from
     * @param int $offset
     * @param int $length
     *
     * @return string
     */
    public function callback($opcode, $from, $offset, $length): string;
}
