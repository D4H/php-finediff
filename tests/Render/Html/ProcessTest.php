<?php

namespace FineDiff\Tests\Render\Html;

use FineDiff\Parser\OperationCodes;
use FineDiff\Render\Html;
use FineDiff\Render\RendererInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{
    /**
     * @var RendererInterface
     */
    protected $html;

    public function setUp(): void
    {
        $this->html = new Html();
    }

    public function tearDown(): void
    {
        m::close();
    }

    public function testProcess(): void
    {
        $operation_codes = m::mock(OperationCodes::class);
        $operation_codes->shouldReceive('generate')->andReturn('c5i:2c6d')->once();

        $html = $this->html->process('Hello worlds', $operation_codes);

	self::assertEquals($html, 'Hello<ins>2</ins> world<del>s</del>');
    }
}
