<?php

namespace FineDiff\Tests\Delimiters;

use FineDiff\Parser\Operations\Operation;
use FineDiff\Delimiters;
use FineDiff\Parser\Operations\OperationInterface;
use PHPUnit\Framework\TestCase;

class ConstantsTest extends TestCase
{
    public function testParagraphConstant(): void
    {
	    self::assertEquals(Delimiters::PARAGRAPH, "\n\r");
    }

    public function testSentenceConstant(): void
    {
	    self::assertEquals(Delimiters::SENTENCE, ".\n\r");
    }

    public function testWordConstant(): void
    {
	    self::assertEquals(Delimiters::WORD, " \t.\n\r");
    }

    public function testCharacterConstant(): void
    {
	    self::assertEquals(Delimiters::CHARACTER, '');
    }

    public function testCopyConstant(): void
    {
	    self::assertEquals(OperationInterface::COPY, 'c');
    }

    public function testDeleteConstant(): void
    {
	    self::assertEquals(OperationInterface::DELETE, 'd');
    }

    public function testInsertConstant(): void
    {
	    self::assertEquals(OperationInterface::INSERT, 'i');
    }
}
