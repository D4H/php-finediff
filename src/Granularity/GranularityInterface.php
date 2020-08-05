<?php

namespace FineDiff\Granularity;

use ArrayAccess;
use Countable;

interface GranularityInterface extends ArrayAccess, Countable
{
    /**
     * Get the delimiters that make up the granularity.
     *
     * @return array
     */
    public function getDelimiters(): array;

    /**
     * Set the delimiters that make up the granularity.
     *
     * @param array $delimiters
     * @return void
     */
    public function setDelimiters(array $delimiters);
}
