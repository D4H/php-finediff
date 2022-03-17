<?php

namespace FineDiff\Tests\Granularity;

use FineDiff\Delimiters;
use FineDiff\Granularity\GranularityInterface;
use FineDiff\Granularity\Paragraph;
use PHPUnit\Framework\TestCase;

class ParagraphTest extends TestCase
{
    /**
     * @var GranularityInterface
     */
    protected $granularity;

    /**
     * @var string[]
     */
    protected $delimiters = [
        Delimiters::PARAGRAPH,
    ];

    public function setUp(): void
    {
        $this->granularity = new Paragraph();
    }

    public function testGetDelimiters(): void
    {
	    self::assertEquals($this->granularity->getDelimiters(), $this->delimiters);
    }
}
