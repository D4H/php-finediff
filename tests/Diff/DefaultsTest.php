<?php

namespace FineDiff\Tests\Diff;

use FineDiff\Diff;
use FineDiff\Granularity\Character;
use FineDiff\Granularity\GranularityInterface;
use FineDiff\Parser\Parser;
use FineDiff\Parser\ParserInterface;
use FineDiff\Render\Html;
use FineDiff\Render\Renderer;
use FineDiff\Render\RendererInterface;
use PHPUnit\Framework\TestCase;

class DefaultsTest extends TestCase
{
    /**
     * @var Diff
     */
    private $diff;

    public function setUp(): void
    {
        $this->diff = new Diff();
    }

    public function testGetGranularity(): void
    {
	self::assertInstanceOf(Character::class, $this->diff->getGranularity());
    }

    public function testGetRenderer(): void
    {
	    self::assertInstanceOf(Html::class, $this->diff->getRenderer());
	    self::assertInstanceOf(Renderer::class, $this->diff->getRenderer());
	    self::assertInstanceOf(RendererInterface::class, $this->diff->getRenderer());
    }

    public function testGetParser(): void
    {
	    self::assertInstanceOf(Parser::class, $this->diff->getParser());
	    self::assertInstanceOf(ParserInterface::class, $this->diff->getParser());
    }
}
