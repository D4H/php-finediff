<?php

namespace FineDiff\Tests\Usage;

use FineDiff\Diff;
use FineDiff\Exceptions\GranularityCountException;
use FineDiff\Granularity\GranularityInterface;
use FineDiff\Render\Text;
use FineDiff\Render\Html;
use FineDiff\Granularity\Character;
use FineDiff\Granularity\Word;
use FineDiff\Granularity\Sentence;
use FineDiff\Granularity\Paragraph;
use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param GranularityInterface $granularity
     * @param string $from
     * @param string $to
     * @param string $operationCodes
     * @param string $html
     *
     * @throws GranularityCountException
     */
    public function testInsertGranularity(
        GranularityInterface $granularity,
        string $from,
        string $to,
        string $operationCodes,
        string $html
    ) {
        // Arrange
        $diff = new Diff($granularity);
        $generatedOperationCodes = $diff->getOperationCodes($from, $to);

        // Generate operation codes
        $this->assertEquals($operationCodes, $generatedOperationCodes);

        // Render to text from operation codes
        $render = new Text();
        $this->assertEquals($to, $render->process($from, $generatedOperationCodes));

        // Render to html from operation codes
        $render = new Html();
        $this->assertEquals($html, $render->process($from, $generatedOperationCodes));

        // Render
        $this->assertEquals($html, $diff->render($from, $to));
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'Character' => array_merge(
                [new Character()],
                $this->getFile('character/simple')
            ),
            'Paragraph' => array_merge(
                [new Paragraph()],
                $this->getFile('paragraph/simple')
            ),
            'Sentence' => array_merge(
                [new Sentence()],
                $this->getFile('sentence/simple')
            ),
            'Word' => array_merge(
                [new Word()],
                $this->getFile('word/simple')
            ),
        ];
    }

    /**
     * @param string $file
     *
     * @return array
     */
    private function getFile(string $file): array
    {
        $txt = file_get_contents(__DIR__.'/Resources/'.$file.'.txt');
        $txt = explode('==========', $txt);

        $from = trim($txt[0]);
        $to = trim($txt[1]);
        $operation_codes = trim($txt[2]);
        $html = trim($txt[3]);

        return [$from, $to, $operation_codes, $html];
    }
}
