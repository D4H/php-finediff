<?php

namespace FineDiff\Render;

use FineDiff\Parser\Operations\Operation;
use FineDiff\Parser\Operations\OperationInterface;

class Text extends Renderer
{
    /**
     * @inheritdoc
     */
    public function callback($opcode, $from, $offset, $length): string
    {
        if ($opcode === OperationInterface::COPY || $opcode === OperationInterface::INSERT) {
            return substr($from, $offset, $length);
        }

        return '';
    }
}
