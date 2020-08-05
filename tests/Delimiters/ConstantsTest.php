<?php

namespace FineDiff\Tests\Delimiters;

use FineDiff\Parser\Operations\Operation;
use FineDiff\Delimiters;
use FineDiff\Parser\Operations\OperationInterface;
use PHPUnit\Framework\TestCase;

class ConstantsTest extends TestCase
{
    public function testParagraphConstant()
    {
        $this->assertEquals(Delimiters::PARAGRAPH, "\n\r");
    }

    public function testSentenceConstant()
    {
        $this->assertEquals(Delimiters::SENTENCE, ".\n\r");
    }

    public function testWordConstant()
    {
        $this->assertEquals(Delimiters::WORD, " \t.\n\r");
    }

    public function testCharacterConstant()
    {
        $this->assertEquals(Delimiters::CHARACTER, '');
    }

    public function testCopyConstant()
    {
        $this->assertEquals(OperationInterface::COPY, 'c');
    }

    public function testDeleteConstant()
    {
        $this->assertEquals(OperationInterface::DELETE, 'd');
    }

    public function testInsertConstant()
    {
        $this->assertEquals(OperationInterface::INSERT, 'i');
    }
}
