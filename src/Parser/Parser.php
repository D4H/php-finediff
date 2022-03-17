<?php

namespace FineDiff\Parser;

use FineDiff\Exceptions\GranularityCountException;
use FineDiff\Granularity\GranularityInterface;
use FineDiff\Parser\Operations\Copy;
use FineDiff\Parser\Operations\Delete;
use FineDiff\Parser\Operations\Insert;
use FineDiff\Parser\Operations\OperationInterface;
use FineDiff\Parser\Operations\Replace;

class Parser implements ParserInterface
{
    /**
     * @var GranularityInterface
     */
    protected GranularityInterface $granularity;

    /**
     * @var OperationCodesInterface
     */
    protected OperationCodesInterface $operationCodes;

    /**
     * @var string Text we are comparing against.
     */
    protected string $formText;

    /**
     * @var int Position of the $from_text we are at.
     */
    protected int $fromOffset = 0;

    /**
     * @var OperationInterface|null
     */
    protected ?OperationInterface $lastEdit;

    /**
     * @var int Current position in the granularity array.
     */
    protected int $stackPointer = 0;

    /**
     * @var OperationInterface[] Holds the individual operation codes as the diff takes place.
     */
    protected $edits = [];

    /**
     * @inheritdoc
     */
    public function __construct(GranularityInterface $granularity)
    {
        $this->granularity = $granularity;

        // Set default operation codes generator
        $this->operationCodes = new OperationCodes();
    }

    /**
     * @inheritdoc
     */
    public function getGranularity(): GranularityInterface
    {
        return $this->granularity;
    }

    /**
     * @inheritdoc
     */
    public function setGranularity(GranularityInterface $granularity): void
    {
        $this->granularity = $granularity;
    }

    /**
     * @inheritdoc
     */
    public function getOperationCodes(): OperationCodesInterface
    {
        return $this->operationCodes;
    }

    /**
     * @inheritdoc
     */
    public function setOperationCodes(OperationCodesInterface $operationCodes): void
    {
        $this->operationCodes = $operationCodes;
    }

    /**
     * @inheritdoc
     */
    public function parse($fromText, $toText): OperationCodesInterface
    {
        // Ensure the granularity contains some delimiters
        if (count($this->granularity) === 0) {
            throw new GranularityCountException('Granularity contains no delimiters');
        }

        // Reset internal parser properties
        $this->formText = $fromText;
        $this->fromOffset = 0;
        $this->lastEdit = null;
        $this->stackPointer = 0;
        $this->edits = [];

        // Parse the two string
        $this->process($fromText, $toText);

        // Return processed diff
        $this->operationCodes->setOperationCodes($this->edits);

        return $this->operationCodes;
    }

    /**
     * Actually kicks off the processing. Recursive function.
     *
     * @param string $fromText
     * @param string $toText
     */
    protected function process($fromText, $toText): void
    {
	// Lets get parsing
	/**
	 * @var string|null $delimiters
	 */
        $delimiters = $this->granularity[$this->stackPointer++];
        $hasNextStage = $this->stackPointer < count($this->granularity);

        // Actually perform diff
        $diff = $this->diff($fromText, $toText, $delimiters);

        foreach ($diff as $fragment) {
            // increase granularity
            if ($fragment instanceof Replace && $hasNextStage) {
                $this->process(
                    mb_substr($this->formText, $this->fromOffset, (int)$fragment->getFromLen()),
                    $fragment->getText()
                );
            } elseif ($fragment instanceof Copy && $this->lastEdit instanceof Copy && $this->edits[count($this->edits)-1] instanceof Copy) {
                // fuse copy ops whenever possible
                $this->edits[count($this->edits)-1]->increase($fragment->getFromLen());
                $this->fromOffset += $fragment->getFromLen();
            } else {
                $this->edits[] = $this->lastEdit = $fragment;
                $this->fromOffset += (int)$fragment->getFromLen();
            }
        }

        $this->stackPointer--;
    }

    /**
     * Core parsing function.
     *
     * @param string $fromText
     * @param string $toText
     * @param string $delimiters Delimiter to use for this parse.
     *
     * @return OperationInterface[]
     */
    protected function diff($fromText, $toText, ?string $delimiters): array
    {
        // Empty delimiter means character-level diffing.
        // In such case, use code path optimized for character-level diffing.
        if ($delimiters === null || $delimiters === '') {
            return $this->charDiff($fromText, $toText);
        }

        $result = [];

        // fragment-level diffing
        $fromTextLen = mb_strlen($fromText);
        $toTextLen = mb_strlen($toText);
        $fromFragments = $this->extractFragments($fromText, $delimiters);
        $toFragments = $this->extractFragments($toText, $delimiters);

        $jobs = [[0, $fromTextLen, 0, $toTextLen]];
	$cachedArrayKeys = [];
	$bestFromStart = 0;

        while ($job = array_pop($jobs)) {
            // get the segments which must be diff'ed
            list($fromSegmentStart, $fromSegmentEnt, $toSegmentStart, $toSegmentEnd) = $job;

            // catch easy cases first
            $fromSegmentLength = $fromSegmentEnt - $fromSegmentStart;
            $toSegmentLength = $toSegmentEnd - $toSegmentStart;

            if ($fromSegmentLength === 0 || $toSegmentLength === 0) {
                if ($fromSegmentLength > 0) {
                    $result[$fromSegmentStart * 4] = new Delete($fromSegmentLength);
                } else if ($toSegmentLength > 0) {
                    $result[$fromSegmentStart * 4 + 1] = new Insert(mb_substr($toText, $toSegmentStart, $toSegmentLength));
                }

                continue;
            }

            // find longest copy operation for the current segments
            $bestCopyLength = 0;

            $fromBaseFragmentIndex = $fromSegmentStart;
	    $cachedArrayKeysForCurrentSegment = [];
	    $bestToStart = 0;

            while ($fromBaseFragmentIndex < $fromSegmentEnt) {
                $fromBaseFragment = $fromFragments[$fromBaseFragmentIndex];
                $fromBaseFragmentLength = mb_strlen($fromBaseFragment);

                // performance boost: cache array keys
                if (!isset($cachedArrayKeysForCurrentSegment[$fromBaseFragment])) {
                    if (!isset($cachedArrayKeys[$fromBaseFragment])) {
                        $toAllFragmentIndices = $cachedArrayKeys[$fromBaseFragment] = array_keys($toFragments, $fromBaseFragment, true);
                    }
                    else {
                        $toAllFragmentIndices = $cachedArrayKeys[$fromBaseFragment];
                    }

                    // get only indices which falls within current segment
                    if ($toSegmentStart > 0 || $toSegmentEnd < $toTextLen) {
                        $toFragmentIndices = [];

                        foreach ($toAllFragmentIndices as $toFragmentIndex) {
                            if ($toFragmentIndex < $toSegmentStart) {
                                continue;
                            }

                            if ($toFragmentIndex >= $toSegmentEnd) {
                                break;
                            }

                            $toFragmentIndices[] = $toFragmentIndex;
                        }

                        $cachedArrayKeysForCurrentSegment[$fromBaseFragment] = $toFragmentIndices;
                    } else {
                        $toFragmentIndices = $toAllFragmentIndices;
                    }
                } else {
                    $toFragmentIndices = $cachedArrayKeysForCurrentSegment[$fromBaseFragment];
                }

                // iterate through collected indices
                foreach ($toFragmentIndices as $toBaseFragmentIndex) {
                    $fragmentIndexOffset = $fromBaseFragmentLength;

                    // iterate until no more match
                    while (true) {
                        $fragmentFromIndex = $fromBaseFragmentIndex + $fragmentIndexOffset;

                        if ($fragmentFromIndex >= $fromSegmentEnt) {
                            break;
                        }

                        $fragmentToIndex = $toBaseFragmentIndex + $fragmentIndexOffset;

                        if ($fragmentToIndex >= $toSegmentEnd) {
                            break;
                        }

                        if ($fromFragments[$fragmentFromIndex] !== $toFragments[$fragmentToIndex]) {
                            break;
                        }

                        $fragmentLength = mb_strlen($fromFragments[$fragmentFromIndex]);
                        $fragmentIndexOffset += $fragmentLength;
                    }

                    if ($fragmentIndexOffset > $bestCopyLength) {
                        $bestCopyLength = $fragmentIndexOffset;
                        $bestFromStart = $fromBaseFragmentIndex;
                        $bestToStart = $toBaseFragmentIndex;
                    }
                }

                $fromBaseFragmentIndex += mb_strlen($fromBaseFragment);

                // If match is larger than half segment size, no point trying to find better
                // TODO: Really?
                if ($bestCopyLength >= $fromSegmentLength / 2) {
                    break;
                }

                // No point to keep looking if what is left is less than current best match
                if ($fromBaseFragmentIndex + $bestCopyLength >= $fromSegmentEnt) {
                    break;
                }
            }

            if ($bestCopyLength > 0) {
                $jobs[] = [$fromSegmentStart, $bestFromStart, $toSegmentStart, $bestToStart];
                $result[$bestFromStart * 4 + 2] = new Copy($bestCopyLength);
                $jobs[] = [$bestFromStart + $bestCopyLength, $fromSegmentEnt, $bestToStart + $bestCopyLength, $toSegmentEnd];
            } else {
                $result[$fromSegmentStart * 4 ] = new Replace($fromSegmentLength, mb_substr($toText, $toSegmentStart, $toSegmentLength));
            }
        }

        ksort($result, SORT_NUMERIC);

        return array_values($result);
    }

    /**
     * Same as Parser::diff but tuned for character level granularity.
     *
     * @param string $fromText
     * @param string $toText
     *
     * @return OperationInterface[]
     */
    protected function charDiff($fromText, $toText): array
    {
        $result = [];
        $jobs = [[0, mb_strlen($fromText), 0, mb_strlen($toText)]];

        while ($job = array_pop($jobs)) {
            // get the segments which must be diff'ed
            list($fromSegmentStart, $fromSegmentEnd, $toSegmentStart, $toSegmentEnd) = $job;

            $fromSegmentLen = $fromSegmentEnd - $fromSegmentStart;
            $toSegmentLen = $toSegmentEnd - $toSegmentStart;

            // catch easy cases first
            if ($fromSegmentLen === 0 || $toSegmentLen === 0) {
                if ($fromSegmentLen > 0) {
                    $result[$fromSegmentStart * 4 + 0] = new Delete($fromSegmentLen);
                } else if ($toSegmentLen > 0) {
                    $result[$fromSegmentStart * 4 + 1] = new Insert(mb_substr($toText, $toSegmentStart, $toSegmentLen));
                }

                continue;
            }

            if ($fromSegmentLen >= $toSegmentLen) {
                $copyLen = $toSegmentLen;

                while ($copyLen) {
                    $toCopyStart = $toSegmentStart;
                    $toCopyStartMax = $toSegmentEnd - $copyLen;

                    while ($toCopyStart <= $toCopyStartMax) {
                        $fromCopyStart = strpos(mb_substr($fromText, $fromSegmentStart, $fromSegmentLen), substr($toText, $toCopyStart, $copyLen));

                        if ($fromCopyStart !== false) {
                            $fromCopyStart += $fromSegmentStart;
                            break 2;
                        }

                        $toCopyStart++;
                    }

                    $copyLen--;
		}

		if (!isset($fromCopyStart) || $fromCopyStart === false) {
			throw new \RuntimeException('Unable to find valid fromCopyStart');
		}
            } else {
                $copyLen = $fromSegmentLen;

                while ($copyLen) {
                    $fromCopyStart = $fromSegmentStart;
                    $fromCopyStartMax = $fromSegmentEnd - $copyLen;

                    while ($fromCopyStart <= $fromCopyStartMax) {
                        $toCopyStart = strpos(mb_substr($toText, $toSegmentStart, $toSegmentLen), substr($fromText, $fromCopyStart, $copyLen));

                        if ($toCopyStart !== false) {
                            $toCopyStart += $toSegmentStart;
                            break 2;
                        }

                        $fromCopyStart++;
                    }

                    $copyLen--;
		}

		if (!isset($toCopyStart) || $toCopyStart === false) {
			throw new \RuntimeException('Unable to find valid toCopyStart');
		}
            }

            // match found
            if ($copyLen > 0) {
                $jobs[] = [$fromSegmentStart, $fromCopyStart, $toSegmentStart, $toCopyStart];
                $result[$fromCopyStart * 4 + 2] = new Copy($copyLen);
                $jobs[] = [$fromCopyStart + $copyLen, $fromSegmentEnd, $toCopyStart + $copyLen, $toSegmentEnd];
            }
            // no match,  so delete all, insert all
            else {
                $result[$fromSegmentStart * 4] = new Replace($fromSegmentLen, mb_substr($toText, $toSegmentStart, $toSegmentLen));
            }
        }

        ksort($result, SORT_NUMERIC);

        return array_values($result);
    }

    /**
     * Efficiently fragment the text into an array according to specified delimiters.
     *
     * No delimiters means fragment into single character. The array indices are the offset of the fragments into
     * the input string. A sentinel empty fragment is always added at the end.
     * Careful: No check is performed as to the validity of the delimiters.
     *
     * @param string $text
     * @param string $delimiters
     * @return string[]
     *
     * @return string[]
     */
    protected function extractFragments(string $text, string $delimiters): array
    {
        // special case: split into characters
        if ($delimiters === '') {
            $chars = mb_str_split($text);
            $chars[mb_strlen($text)] = '';

            return $chars;
        }

        $fragments = [];
        $start = 0;
        $end = 0;

        while (true) {
            $end += strcspn($text, $delimiters, $end);
            $end += strspn($text, $delimiters, $end);

            if ($end === $start) {
                break;
            }

            $fragments[$start] = mb_substr($text, $start, $end - $start);
            $start = $end;
        }

        $fragments[$start] = '';

        return $fragments;
    }
}
