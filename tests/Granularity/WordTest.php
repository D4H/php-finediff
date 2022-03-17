<?php

namespace FineDiff\Tests\Granularity;

use FineDiff\Delimiters;
use FineDiff\Granularity\GranularityInterface;
use FineDiff\Granularity\Word;
use PHPUnit\Framework\TestCase as TestCase;

class WordTest extends TestCase
{
    protected GranularityInterface $granularity;

    /**
     * @var string[]
     */
    protected $delimiters = [
        Delimiters::PARAGRAPH,
        Delimiters::SENTENCE,
        Delimiters::WORD,
    ];

    public function setUp(): void
    {
        $this->granularity = new Word();
    }

    public function testGetDelimiters(): void
    {
	    self::assertEquals($this->granularity->getDelimiters(), $this->delimiters);
    }
}
