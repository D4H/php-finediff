<?php

namespace FineDiff\Parser\Operations;

class Copy implements OperationInterface
{
    /**
     * @var int
     */
    private int $len;

    /**
     * Set the initial length.
     *
     * @param int $len Length of string.
     */
    public function __construct(int $len)
    {
        $this->len = $len;
    }

    /**
     * @inheritdoc
     */
    public function getFromLen(): int
    {
        return $this->len;
    }

    /**
     * @inheritdoc
     */
    public function getToLen(): int
    {
        return $this->len;
    }

    /**
     * @inheritdoc
     */
    public function getOperationCode(): string
    {
        if ($this->len === 1) {
            return static::COPY;
        }

        return static::COPY.$this->len;
    }

    /**
     * Increase the length of the string.
     *
     * @param int $size Amount to increase the string length by.
     * @return int New length
     */
    public function increase($size): int
    {
        return $this->len += $size;
    }
}
