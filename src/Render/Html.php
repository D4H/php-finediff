<?php

namespace FineDiff\Render;

use FineDiff\Parser\Operations\Operation;
use FineDiff\Parser\Operations\OperationInterface;
use InvalidArgumentException;

class Html extends Renderer
{
    /**
     * @var array<string,string|int> $configRenderer
     */
    protected $configRenderer = [];

    /**
     * @param array<string,string|int> $configRenderer
     */
    public function __construct(array $configRenderer = [])
    {
        $configRenderer += [
            'encoding' => 'UTF-8',
            'del_prefix' => '<del>',
            'del_suffix' => '</del>',
            'ins_prefix' => '<ins>',
            'ins_suffix' => '</ins>',
            'quote_style' => ENT_COMPAT | (defined('ENT_HTML401') ? ENT_HTML401 : 0),
        ];

        $this->configRenderer = $configRenderer;
    }

    /**
     * {@inheritDoc}
     */
    public function callback($opcode, $from, $offset, $length): string
    {
        switch ($opcode) {
            case OperationInterface::COPY:
                return $this->onCopy($from, $offset, $length);
            case OperationInterface::DELETE:
                return $this->onDelete($from, $offset, $length);
            case OperationInterface::INSERT:
                return $this->onInsert($from, $offset, $length);
            default:
                throw new InvalidArgumentException('Undefined operation code "'.$opcode.'"');
        }
    }

    /**
     * @param string $from
     * @param int $offset
     * @param int $length
     *
     * @return string
     */
    protected function onCopy($from, $offset, $length): string
    {
        return $this->htmlentities(mb_substr($from, $offset, $length));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function htmlentities(string $string): string
    {
        return htmlentities(
            $string,
            (int) $this->configRenderer['quote_style'],
            (string) $this->configRenderer['encoding']
        );
    }

    /**
     * @param string $from
     * @param int $offset
     * @param int $length
     *
     * @return string
     */
    protected function onDelete($from, $offset, $length): string
    {
        $deletion = mb_substr($from, $offset, $length);

        return $this->wrap($this->htmlentities($deletion), 'del_prefix', 'del_suffix');
    }

    /**
     * @param string $string
     * @param string $prefix
     * @param string $suffix
     *
     * @return string
     */
    protected function wrap($string, $prefix, $suffix): string
    {
        return $this->configRenderer[$prefix].$string.$this->configRenderer[$suffix];
    }

    /**
     * @param string $from
     * @param int $offset
     * @param int $length
     *
     * @return string
     */
    protected function onInsert($from, $offset, $length): string
    {
        $insertion = mb_substr($from, $offset, $length);

        return $this->wrap($this->htmlentities($insertion), 'ins_prefix', 'ins_suffix');
    }
}
