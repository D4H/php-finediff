<?php

namespace FineDiff\Parser;

use FineDiff\Exceptions\OperationException;
use FineDiff\Parser\Operations\OperationInterface;

class OperationCodes implements OperationCodesInterface
{
    /**
     * @var string[] Individual operation codes.
     */
    protected $operationCodes = [];

    /**
     * @inheritdoc
     */
    public function getOperationCodes(): array
    {
        return $this->operationCodes;
    }

    /**
     * @inheritdoc
     */
    public function setOperationCodes(array $operationCodes)
    {
        $this->operationCodes = [];

        // Ensure that all elements of the array are of the correct type
        /** @var FineDiff\Parser\Operations\OperationInterface $operation_code */
        foreach ($operationCodes as $operationCode) {
            if (!is_a($operationCode, OperationInterface::class)) {
                throw new OperationException('Invalid operation code object');
            }

            $this->operationCodes[] = $operationCode->getOperationCode();
        }
    }

    /**
     * @inheritdoc
     */
    public function generate(): string
    {
        return implode('', $this->operationCodes);
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->generate();
    }
}
