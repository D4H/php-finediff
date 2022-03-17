<?php

namespace FineDiff\Tests\Granularity;

use FineDiff\Delimiters;
use FineDiff\Granularity\GranularityInterface;
use FineDiff\Granularity\Sentence;
use PHPUnit\Framework\TestCase;

class SentenceTest extends TestCase
{
    protected GranularityInterface $granularity;

    /**
     * @var string[]
     */
    protected $delimiters = [
        Delimiters::PARAGRAPH,
        Delimiters::SENTENCE,
    ];

    public function setUp(): void
    {
        $this->granularity = new Sentence();
    }

    public function testGetDelimiters(): void
    {
	    self::assertEquals($this->granularity->getDelimiters(), $this->delimiters);
    }
}
