<?php

namespace FineDiff\Parser\Operations;

class Insert implements OperationInterface
{
    /**
     * @var string
     */
    private string $text;

    /**
     * Sets the text that the operation is working with.
     *
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * @inheritdoc
     */
    public function getFromLen(): int
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function getToLen(): int
    {
        return mb_strlen($this->text);
    }

    /**
     * @inheritdoc
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @inheritdoc
     */
    public function getOperationCode(): string
    {
        $to_len = mb_strlen($this->text);

        if ($to_len === 1) {
            return static::INSERT.':'.$this->text;
        }

        return static::INSERT.$to_len.':'.$this->text;
    }
}
