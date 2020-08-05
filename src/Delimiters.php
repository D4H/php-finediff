<?php

namespace FineDiff;

abstract class Delimiters
{
    const PARAGRAPH = "\n\r";
    const SENTENCE = ".\n\r";
    const WORD = " \t.\n\r";
    const CHARACTER = '';

    /**
     * Do not allow this class to be instantiated.
     */
    private function __construct()
    {
    }
}
