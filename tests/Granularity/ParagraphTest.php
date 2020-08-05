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
     * @var array
     */
    protected $delimiters = [
        Delimiters::PARAGRAPH,
    ];

    public function setUp(): void
    {
        $this->granularity = new Paragraph();
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
