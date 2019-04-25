<?php

namespace FineDiffTests\Render\Text;

use FineDiffTests\TestCase;
use CogPowered\FineDiff\Render\Text;

class CallbackTest extends TestCase
{
    /**
     * @var \CogPowered\FineDiff\Render\RendererInterface
     */
    protected $text;
    
    public function setUp()
    {
        $this->text = new Text;
    }

    public function testCopy()
    {
        $output = $this->text->callback('c', 'Hello', 0, 5);
        $this->assertEquals($output, 'Hello');

        $output = $this->text->callback('c', 'Hello', 0, 3);
        $this->assertEquals($output, 'Hel');
    }

    public function testDelete()
    {
        $output = $this->text->callback('d', 'elephant', 0, 100);
        $this->assertEquals($output, '');

        $output = $this->text->callback('d', 'elephant', 3, 4);
        $this->assertEquals($output, '');
    }

    public function testInsert()
    {
        $output = $this->text->callback('i', 'monkey', 0, 6);
        $this->assertEquals($output, 'monkey');

        $output = $this->text->callback('i', 'monkey', 2, 3);
        $this->assertEquals($output, 'nke');
    }
}
