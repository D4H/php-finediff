<?php

namespace FineDiff\Parser\Operations;

class Delete implements OperationInterface
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
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function getOperationCode(): string
    {
        if ($this->len === 1) {
            return static::DELETE;
        }

        return static::DELETE.$this->len;
    }
}
