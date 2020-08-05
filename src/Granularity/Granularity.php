<?php

namespace FineDiff\Granularity;

trait Granularity
{
    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return isset($this->delimiters[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return isset($this->delimiters[$offset]) ? $this->delimiters[$offset] : null;
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
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
    public function offsetUnset($offset)
    {
        unset($this->delimiters[$offset]);
    }

    /**
     * Return the number of delimiters this granularity contains.
     *
     * @return int
     */
    public function count()
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
