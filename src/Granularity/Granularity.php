<?php

namespace FineDiff\Granularity;

trait Granularity
{
    /**
     * @inheritdoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->delimiters[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->delimiters[$offset] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->delimiters[] = $value;
        } else {
            $this->delimiters[$offset] = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->delimiters[$offset]);
    }

    /**
     * Return the number of delimiters this granularity contains.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->delimiters);
    }

    /**
     * @inheritdoc
     */
    public function getDelimiters(): array
    {
        return $this->delimiters;
    }

    /**
     * @inheritdoc
     */
    public function setDelimiters(array $delimiters)
    {
        $this->delimiters = $delimiters;
    }
}
