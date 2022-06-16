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
	 *
	 * @throws GranularityCountException
	 */
	public function testInsertGranularity(
		GranularityInterface $granularity,
		string $from,
		string $to,
		string $operationCodes,
		string $html
	): void {
		// Arrange
		$diff = new Diff($granularity);
		$generatedOperationCodes = $diff->getOperationCodes($from, $to);

		// Generate operation codes
		self::assertEquals($operationCodes, $generatedOperationCodes);

		// Render to text from operation codes
		$render = new Text();
		self::assertEquals($to, $render->process($from, $generatedOperationCodes));

		// Render to html from operation codes
		$render = new Html();
		self::assertEquals($html, $render->process($from, $generatedOperationCodes));

		// Render
		self::assertEquals($html, $diff->render($from, $to));
	}

	/**
	 * @return array<string,array<int,mixed>>
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
	 *
	 * @return array<int,string>
	 */
	private function getFile(string $file): array
	{
		$txt = (string) file_get_contents(__DIR__.'/Resources/'.$file.'.txt');
		$txt = explode('==========', $txt);

		$from = trim($txt[0]);
		$to = trim($txt[1]);
		$operation_codes = trim($txt[2]);
		$html = trim($txt[3]);

		return [$from, $to, $operation_codes, $html];
	}
}
