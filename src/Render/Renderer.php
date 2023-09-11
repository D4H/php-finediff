<?php

namespace FineDiff\Render;

use FineDiff\Parser\OperationCodesInterface;
use FineDiff\Parser\Operations\OperationInterface;
use InvalidArgumentException;

abstract class Renderer implements RendererInterface
{
    /**
     * {@inheritdoc}
     */
    public function process($fromText, $operationCodes): string
    {
        // Validate operation codes
        if (!is_string($operationCodes) && !($operationCodes instanceof OperationCodesInterface)) {
            throw new InvalidArgumentException('Invalid operation codes type');
        }

        $operationCodes = ($operationCodes instanceof OperationCodesInterface) ? $operationCodes->generate() : $operationCodes;

        // Holds the generated string that is returned
        $output = '';

        $operationCodesLen = mb_strlen($operationCodes);
        $fromOffset = 0;
        $operationCodesOffset = 0;

        while ($operationCodesOffset < $operationCodesLen) {
            $opcode = mb_substr($operationCodes, $operationCodesOffset, 1);
            $operationCodesOffset++;
            $n = (int) mb_substr($operationCodes, $operationCodesOffset);

            if ($n) {
                $operationCodesOffset += mb_strlen((string)$n);
            } else {
                $n = 1;
            }

            switch ($opcode) {
                case OperationInterface::COPY:
                case OperationInterface::DELETE:
                    $data = $this->callback($opcode, $fromText, $fromOffset, $n);
                    $fromOffset += $n;
                    break;
                case OperationInterface::INSERT:
                    $data = $this->callback($opcode, $operationCodes, $operationCodesOffset + 1, $n);
                    $operationCodesOffset += 1 + $n;
                    break;
                default:
                    $data = '';
            }

            $output .= $data;
        }

        return $output;
    }
}
