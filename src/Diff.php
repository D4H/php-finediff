<?php

namespace FineDiff;

use FineDiff\Exceptions\GranularityCountException;
use FineDiff\Granularity\GranularityInterface;
use FineDiff\Parser\OperationCodesInterface;
use FineDiff\Render\RendererInterface;
use FineDiff\Parser\ParserInterface;
use FineDiff\Granularity\Character;
use FineDiff\Render\Html;
use FineDiff\Parser\Parser;

class Diff
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @param GranularityInterface $granularity
     * @param RendererInterface $renderer
     * @param ParserInterface $parser
     */
    public function __construct(
        GranularityInterface $granularity = null,
        RendererInterface $renderer = null,
        ParserInterface $parser = null
    ) {
        // Set some sensible defaults
        // Set the granularity of the diff
        $granularity = ($granularity !== null) ? $granularity : new Character();

        // Set the renderer to use when calling Diff::render
        $this->renderer = ($renderer !== null) ? $renderer : new Html();

        // Set the diff parser
        $this->parser = ($parser !== null) ? $parser : new Parser($granularity);
    }

    /**
     * Returns the granularity object used by the parser.
     *
     * @return GranularityInterface
     */
    public function getGranularity(): GranularityInterface
    {
        return $this->parser->getGranularity();
    }

    /**
     * Set the granularity level of the parser.
     *
     * @param GranularityInterface $granularity
     */
    public function setGranularity(GranularityInterface $granularity)
    {
        $this->parser->setGranularity($granularity);
    }

    /**
     * Get the renderer.
     *
     * @return RendererInterface
     */
    public function getRenderer(): RendererInterface
    {
        return $this->renderer;
    }

    /**
     * Set the renderer.
     *
     * @param RendererInterface $renderer
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Get the parser responsible for generating the diff/operation codes.
     *
     * @return ParserInterface
     */
    public function getParser(): ParserInterface
    {
        return $this->parser;
    }

    /**
     * Set the parser.
     *
     * @param ParserInterface $parser
     */
    public function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Gets the diff / operation codes between two strings.
     * Returns the opcode diff which can be used for example, to
     * to generate a HTML report of the differences.
     *
     * @param string $fromText
     * @param string $toText
     *
     * @throws GranularityCountException
     *
     * @return OperationCodesInterface
     */
    public function getOperationCodes($fromText, $toText): OperationCodesInterface
    {
        return $this->parser->parse($fromText, $toText);
    }

    /**
     * Render the difference between two strings.
     * By default will return the difference as HTML.
     *
     * @param string $fromText
     * @param string $toText
     *
     * @throws GranularityCountException
     *
     * @return string
     */
    public function render($fromText, $toText): string
    {
        // First we need the operation codes
        $operationCodes = $this->getOperationCodes($fromText, $toText);

        return $this->renderer->process($fromText, $operationCodes);
    }
}
