<?php

namespace FineDiff\Tests\Granularity;

use FineDiff\Delimiters;
use FineDiff\Granularity\GranularityInterface;
use FineDiff\Granularity\Word;
use PHPUnit\Framework\TestCase as TestCase;

class WordTest extends TestCase
{
    /**
     * @var GranularityInterface
     */
    protected $granularity;

    /**
     * @var array
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

    public function testExtendsAndImplements()
    {
        $this->assertInstanceOf(GranularityInterface::class, $this->granularity);
    }

    public function testGetDelimiters()
    {
        $this->assertEquals($this->granularity->getDelimiters(), $this->delimiters);
    }
}
