<?php

namespace FineDiff\Parser;

use FineDiff\Exceptions\GranularityCountException;
use FineDiff\Granularity\GranularityInterface;

interface ParserInterface
{
    /**
     * Creates an instance.
     *
     * @param GranularityInterface $granularity
     */
    public function __construct(GranularityInterface $granularity);

    /**
     * Granularity the parser is working with.
     *
     * @return GranularityInterface
     */
    public function getGranularity(): GranularityInterface;

    /**
     * Set the granularity that the parser is working with.
     *
     * @param GranularityInterface $granularity
     */
    public function setGranularity(GranularityInterface $granularity): void;

    /**
     * Get the operation codes object that is used to store all the operation codes.
     *
     * @return OperationCodesInterface
     */
    public function getOperationCodes(): OperationCodesInterface;

    /**
     * Set the operation codes object used to store all the operation codes for this parse.
     *
     * @param OperationCodesInterface $operationCodes
     *
     * @return void
     */
    public function setOperationCodes(OperationCodesInterface $operationCodes): void;

    /**
     * Generates the operation codes needed to transform one string to another.
     *
     * @param string $fromText
     * @param string $toText
     *
     * @return OperationCodesInterface
     *@throws GranularityCountException
     */
    public function parse($fromText, $toText): OperationCodesInterface;
}
