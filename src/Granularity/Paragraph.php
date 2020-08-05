<?php

namespace FineDiff\Granularity;

use FineDiff\Delimiters;

class Paragraph implements GranularityInterface
{
    use Granularity;

    /**
     * @var array
     */
    private $delimiters = [
        Delimiters::PARAGRAPH,
    ];
}
