<?php declare(strict_types=1);

namespace XoopsModules\Wfchannel;

/*
 * Copyright (c) 2003 Jose Solorzano.  All rights reserved.
 * Redistribution of source must retain this copyright notice.
 */

//require __DIR__ . '/htmlparser.inc';

/**
 * Class Html2Text. (HtmlParser example.)
 * Converts HTML to ASCII attempting to preserve
 * document structure.
 * To use, create an instance of Html2Text passing
 * the text to convert and the desired maximum
 * number of characters per line. Then invoke
 * convert() which returns ASCII text.
 */
class Html2Text
{
    // Private fields

    public $iCurrentLine = '';
    public $iCurrentWord = '';
    public $iCurrentWordArray;
    public $iCurrentWordIndex;
    public $iInScript;
    public $iListLevel   = 0;
    public $iHtmlText;
    public $iMaxColumns;
    public $iHtmlParser;
    // Constants

    public $TOKEN_BR      = 0;
    public $TOKEN_P       = 1;
    public $TOKEN_LI      = 2;
    public $TOKEN_AFTERLI = 3;
    public $TOKEN_UL      = 4;
    public $TOKEN_ENDUL   = 5;

    /**
     * @param $aHtmlText
     * @param $aMaxColumns
     */
    public function __construct($aHtmlText, $aMaxColumns)
    {
        $this->iHtmlText   = $aHtmlText;
        $this->iMaxColumns = $aMaxColumns;
    }

    public function convert(): string
    {
        $this->iHtmlParser = new HtmlParser($this->iHtmlText);
        $wholeText         = '';
        while (false !== ($line = $this->getLine())) {
            $wholeText .= ($line . "\r\n");
        }

        return $wholeText;
    }

    /**
     * @return bool|string
     */
    public function getLine()
    {
        while (true) {
            if (!$this->addWordToLine($this->iCurrentWord)) {
                $retvalue           = $this->iCurrentLine;
                $this->iCurrentLine = '';

                return $retvalue;
            }
            $word = $this->getWord();
            if (false === $word) {
                if ('' === $this->iCurrentLine) {
                    break;
                }
                $retvalue           = $this->iCurrentLine;
                $this->iCurrentLine = '';
                $this->iInText      = false;
                $this->iCurrentWord = '';

                return $retvalue;
            }
        }

        return false;
    }

    /**
     * @param $word
     * @return bool
     */
    public function addWordToLine($word)
    {
        if ($this->iInScript) {
            return true;
        }
        $prevLine = $this->iCurrentLine;
        if ($word === $this->TOKEN_BR) {
            $this->iCurrentWord = '';

            return false;
        }
        if ($word === $this->TOKEN_P) {
            $this->iCurrentWord = $this->TOKEN_BR;

            return false;
        }
        if ($word === $this->TOKEN_UL) {
            $this->iCurrentWord = $this->TOKEN_BR;

            return false;
        }
        if ($word === $this->TOKEN_ENDUL) {
            $this->iCurrentWord = $this->TOKEN_BR;

            return false;
        }
        if ($word === $this->TOKEN_LI) {
            $this->iCurrentWord = $this->TOKEN_AFTERLI;

            return false;
        }
        $toAdd = $word;
        if ($word === $this->TOKEN_AFTERLI) {
            $toAdd = '';
        }
        if ('' !== $prevLine) {
            $prevLine .= ' ';
        } else {
            $prevLine = $this->getIndentation($word === $this->TOKEN_AFTERLI);
        }
        $candidateLine = $prevLine . $toAdd;
        if (\mb_strlen($candidateLine) > $this->iMaxColumns && '' !== $prevLine) {
            return false;
        }
        $this->iCurrentLine = $candidateLine;

        return true;
    }

    /**
     * @return bool|int|string
     */
    public function getWord()
    {
        while (true) {
            if (\NODE_TYPE_TEXT === $this->iHtmlParser->iNodeType) {
                if (!$this->iInText) {
                    $words                   = $this->splitWords($this->iHtmlParser->iNodeValue);
                    $this->iCurrentWordArray = $words;
                    $this->iCurrentWordIndex = 0;
                    $this->iInText           = true;
                }
                if ($this->iCurrentWordIndex < \count($this->iCurrentWordArray)) {
                    $this->iCurrentWord = $this->iCurrentWordArray[$this->iCurrentWordIndex++];

                    return $this->iCurrentWord;
                }

                $this->iInText = false;
            } elseif (\NODE_TYPE_ELEMENT === $this->iHtmlParser->iNodeType) {
                if (0 === \strcasecmp($this->iHtmlParser->iNodeName, 'br')) {
                    $this->iHtmlParser->parse();
                    $this->iCurrentWord = $this->TOKEN_BR;

                    return $this->iCurrentWord;
                }

                if (0 === \strcasecmp($this->iHtmlParser->iNodeName, 'p')) {
                    $this->iHtmlParser->parse();
                    $this->iCurrentWord = $this->TOKEN_P;

                    return $this->iCurrentWord;
                } elseif (0 === \strcasecmp($this->iHtmlParser->iNodeName, 'script')) {
                    $this->iHtmlParser->parse();
                    $this->iCurrentWord = '';
                    $this->iInScript    = true;

                    return $this->iCurrentWord;
                } elseif (0 === \strcasecmp($this->iHtmlParser->iNodeName, 'ul')
                          || 0 == \strcasecmp($this->iHtmlParser->iNodeName, 'ol')) {
                    $this->iHtmlParser->parse();
                    $this->iCurrentWord = $this->TOKEN_UL;
                    $this->iListLevel++;

                    return $this->iCurrentWord;
                } elseif (0 === \strcasecmp($this->iHtmlParser->iNodeName, 'li')) {
                    $this->iHtmlParser->parse();
                    $this->iCurrentWord = $this->TOKEN_LI;

                    return $this->iCurrentWord;
                }
            } elseif (\NODE_TYPE_ENDELEMENT === $this->iHtmlParser->iNodeType) {
                if (0 === \strcasecmp($this->iHtmlParser->iNodeName, 'script')) {
                    $this->iHtmlParser->parse();
                    $this->iCurrentWord = '';
                    $this->iInScript    = false;

                    return $this->iCurrentWord;
                }

                if (0 === \strcasecmp($this->iHtmlParser->iNodeName, 'ul')
                    || 0 === \strcasecmp($this->iHtmlParser->iNodeName, 'ol')) {
                    $this->iHtmlParser->parse();
                    $this->iCurrentWord = $this->TOKEN_ENDUL;
                    if ($this->iListLevel > 0) {
                        $this->iListLevel--;
                    }

                    return $this->iCurrentWord;
                }
            }
            if (!$this->iHtmlParser->parse()) {
                break;
            }
        }

        return false;
    }

    /**
     * @param $text
     */
    public function splitWords($text): array
    {
        $words      = \preg_split("[ \t\r\n]+", $text);
        $wordsCount = \count($words);
        for ($idx = 0; $idx < $wordsCount; $idx++) {
            $words[$idx] = $this->htmlDecode($words[$idx]);
        }

        return $words;
    }

    /**
     * @param $text
     * @return mixed
     */
    public function htmlDecode($text)
    {
        // TBD
        return $text;
    }

    /**
     * @param $hasLI
     */
    public function getIndentation($hasLI): string
    {
        $indent = '';
        $idx    = 0;
        for ($idx = 0; $idx < ($this->iListLevel - 1); $idx++) {
            $indent .= '  ';
        }
        if ($this->iListLevel > 0) {
            $indent = $hasLI ? ($indent . '- ') : ($indent . '  ');
        }

        return $indent;
    }
}
