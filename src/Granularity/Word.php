<?php

namespace FineDiff\Granularity;

use FineDiff\Delimiters;

class Word implements GranularityInterface
{
    use Granularity;

    /**
     * @var string[]
     */
    private $delimiters = [
        Delimiters::PARAGRAPH,
        Delimiters::SENTENCE,
        Delimiters::WORD,
    ];
}
