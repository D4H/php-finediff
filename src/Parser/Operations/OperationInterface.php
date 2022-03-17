<?php

namespace FineDiff\Parser\Operations;

interface OperationInterface
{
    /**
     * Copy code
     *
     * @var string
     */
    const COPY = 'c';

    /**
     * Delete code
     *
     * @var string
     */
    const DELETE = 'd';

    /**
     * Insert code
     *
     * @var string
     */
    const INSERT = 'i';

    /**
     * @return int|string
     */
    public function getFromLen(): int|string;

    /**
     * @return int
     */
    public function getToLen(): int;

    /**
     * @return string Operation code for this operation.
     */
    public function getOperationCode(): string;
}
