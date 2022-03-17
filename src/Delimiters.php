<?php

namespace FineDiff;

abstract class Delimiters
{
	public const PARAGRAPH = "\n\r";
	public const SENTENCE = ".\n\r";
	public const WORD = " \t.\n\r";
	public const CHARACTER = '';

	/**
	 * Do not allow this class to be instantiated.
	 */
	private function __construct()
	{
	}
}
