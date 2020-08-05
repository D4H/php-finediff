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

        $operation_codes_len    = strlen($operationCodes);
        $from_offset    = 0;
        $operation_codes_offset = 0;

        while ($operation_codes_offset < $operation_codes_len) {

            $opcode = $operationCodes[$operation_codes_offset];
            $operation_codes_offset++;
            $n = (int)substr($operationCodes, $operation_codes_offset);

            if ($n) {
                $operation_codes_offset += strlen((string)$n);
            } else {
                $n = 1;
            }

            switch ($opcode) {
                case OperationInterface::COPY:
                case OperationInterface::DELETE:
                    $data = $this->callback($opcode, $fromText, $from_offset, $n);
                    $from_offset += $n;
                    break;
                case OperationInterface::INSERT:
                    $data = $this->callback($opcode, $operationCodes, $operation_codes_offset + 1, $n);
                    $operation_codes_offset += 1 + $n;
                    break;
                default:
                    $data = '';
            }

            $output .= $data;
        }

        return $output;
    }
}
