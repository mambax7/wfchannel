<?php declare(strict_types=1);

namespace XoopsModules\Wfchannel;

/*
 * Copyright (c) 2003 Jose Solorzano.  All rights reserved.
 * Redistribution of source must retain this copyright notice.
 *
 * Jose Solorzano (https://jexpert.us) is a software consultant.
 *
 * Contributions by:
 * - Leo West (performance improvements)
 */

\define('NODE_TYPE_START', 0);
\define('NODE_TYPE_ELEMENT', 1);
\define('NODE_TYPE_ENDELEMENT', 2);
\define('NODE_TYPE_TEXT', 3);
\define('NODE_TYPE_COMMENT', 4);
\define('NODE_TYPE_DONE', 5);

/**
 * Class HtmlParser.
 * To use, create an instance of the class passing
 * HTML text. Then invoke parse() until it's false.
 * When parse() returns true, $iNodeType, $iNodeName
 * $iNodeValue and $iNodeAttributes are updated.
 *
 * To create an HtmlParser instance you may also
 * use convenience functions HtmlParser_ForFile
 * and HtmlParser_ForURL.
 */
class HtmlParser
{
    /**
     * Field iNodeType.
     * May be one of the NODE_TYPE_* constants above.
     */
    public $iNodeType;
    /**
     * Field iNodeName.
     * For elements, it's the name of the element.
     */
    public $iNodeName = '';
    /**
     * Field iNodeValue.
     * For text nodes, it's the text.
     */
    public $iNodeValue = '';
    /**
     * Field iNodeAttributes.
     * A string-indexed array containing attribute values
     * of the current node. Indexes are always lowercase.
     */
    public $iNodeAttributes;
    // The following fields should be
    // considered private:

    public $iHtmlText;
    public $iHtmlTextLength;
    public $iHtmlTextIndex = 0;
    public $iHtmlCurrentChar;

    /**
     * Constructor.
     * Constructs an HtmlParser instance with
     * the HTML text given.
     * @param $aHtmlText
     */
    public function __construct($aHtmlText)
    {
        $this->iHtmlText       = $aHtmlText;
        $this->iHtmlTextLength = \mb_strlen($aHtmlText);
        $this->setTextIndex(0);
    }

    /**
     * Method parse.
     * Parses the next node. Returns false only if
     * the end of the HTML text has been reached.
     * Updates values of iNode* fields.
     */
    public function parse()
    {
        $text = $this->skipToElement();
        if ('' !== $text) {
            $this->iNodeType  = \NODE_TYPE_TEXT;
            $this->iNodeName  = 'Text';
            $this->iNodeValue = $text;

            return true;
        }

        return $this->readTag();
    }

    public function clearAttributes(): void
    {
        $this->iNodeAttributes = [];
    }

    /**
     * @return bool
     */
    public function readTag()
    {
        if ('<' !== $this->iCurrentChar) {
            $this->iNodeType = \NODE_TYPE_DONE;

            return false;
        }
        $this->skipInTag('<');
        $this->clearAttributes();
        $name = $this->skipToBlanksInTag();
        $pos  = \mb_strpos($name, '/');
        if (0 === $pos) {
            $this->iNodeType  = \NODE_TYPE_ENDELEMENT;
            $this->iNodeName  = \mb_substr($name, 1);
            $this->iNodeValue = '';
        } else {
            if (!$this->isValidTagIdentifier($name)) {
                $comment = false;
                if ('!--' === $name) {
                    $rest = $this->skipToStringInTag('-->');
                    if ('' !== $rest) {
                        $this->iNodeType  = \NODE_TYPE_COMMENT;
                        $this->iNodeName  = 'Comment';
                        $this->iNodeValue = '<' . $name . $rest;
                        $comment          = true;
                    }
                }
                if (!$comment) {
                    $this->iNodeType  = \NODE_TYPE_TEXT;
                    $this->iNodeName  = 'Text';
                    $this->iNodeValue = '<' . $name;
                }

                return true;
            }

            $this->iNodeType  = \NODE_TYPE_ELEMENT;
            $this->iNodeValue = '';
            $nameLength       = \mb_strlen($name);
            $this->iNodeName  = $name;
            if ($nameLength > 0 && '/' === \mb_substr($name, $nameLength - 1, 1)) {
                $this->iNodeName = \mb_substr($name, 0, $nameLength - 1);
            }
        }
        while ($this->skipBlanksInTag()) {
            $attrName = $this->skipToBlanksOrEqualsInTag();
            if ('' !== $attrName) {
                $this->skipBlanksInTag();
                if ('=' === $this->iCurrentChar) {
                    $this->skipEqualsInTag();
                    $this->skipBlanksInTag();
                    $value                                            = $this->readValueInTag();
                    $this->iNodeAttributes[\mb_strtolower($attrName)] = $value;
                } else {
                    $this->iNodeAttributes[\mb_strtolower($attrName)] = '';
                }
            }
        }
        $this->skipEndOfTag();

        return true;
    }

    /**
     * @param $name
     */
    public function isValidTagIdentifier($name): int
    {
        return \preg_match('/[A-Za-z0-9]+/', $name);
    }

    /**
     * @return bool
     */
    public function skipBlanksInTag()
    {
        return '' !== $this->skipInTag([' ', "\t", "\r", "\n"]);
    }

    public function skipToBlanksOrEqualsInTag(): string
    {
        return $this->skipToInTag([' ', "\t", "\r", "\n", '=']);
    }

    public function skipToBlanksInTag(): string
    {
        return $this->skipToInTag([' ', "\t", "\r", "\n"]);
    }

    public function skipEqualsInTag(): string
    {
        return $this->skipInTag(['=']);
    }

    public function readValueInTag(): string
    {
        $ch    = $this->iCurrentChar;
        $value = '';
        if ('"' === $ch) {
            $this->skipInTag(['"']);
            $value = $this->skipToInTag(['"']);
            $this->skipInTag(['"']);
        } elseif ("\'" === $ch) {
            $this->skipInTag(["'"]);
            $value = $this->skipToInTag(["'"]);
            $this->skipInTag(["'"]);
        } else {
            $value = $this->skipToBlanksInTag();
        }

        return $value;
    }

    /**
     * @param $index
     */
    public function setTextIndex($index): void
    {
        $this->iHtmlTextIndex = $index;
        if ($index >= $this->iHtmlTextLength) {
            $this->iCurrentChar = -1;
        } else {
            $this->iCurrentChar = $this->iHtmlText[$index];
        }
    }

    /**
     * @return bool
     */
    public function moveNext(): ?bool
    {
        if ($this->iHtmlTextIndex < $this->iHtmlTextLength) {
            $this->setTextIndex($this->iHtmlTextIndex + 1);

            return true;
        }

        return false;
    }

    public function skipEndOfTag(): string
    {
        $sb = '';
        if (-1 !== ($ch = $this->iCurrentChar)) {
            $match = ('>' === $ch);
            if (!$match) {
                return $sb;
            }
            $sb .= $ch;
            $this->moveNext();
        }

        return $sb;
    }

    /**
     * @param $chars
     */
    public function skipInTag($chars): string
    {
        $sb = '';
        while (-1 !== ($ch = $this->iCurrentChar)) {
            if ('>' === $ch) {
                return $sb;
            }

            $match      = false;
            $charsCount = \count($chars);
            for ($idx = 0; $idx < $charsCount; $idx++) {
                if ($ch === $chars[$idx]) {
                    $match = true;
                    break;
                }
            }
            if (!$match) {
                return $sb;
            }
            $sb .= $ch;
            $this->moveNext();
        }

        return $sb;
    }

    /**
     * @param $chars
     */
    public function skipToInTag($chars): string
    {
        $sb = '';
        while (-1 !== ($ch = $this->iCurrentChar)) {
            $match = '>' === $ch;
            if (!$match) {
                $charsCount = \count($chars);
                for ($idx = 0; $idx < $charsCount; ++$idx) {
                    if ($ch === $chars[$idx]) {
                        $match = true;
                        break;
                    }
                }
            }
            if ($match) {
                return $sb;
            }
            $sb .= $ch;
            $this->moveNext();
        }

        return $sb;
    }

    public function skipToElement(): string
    {
        $sb = '';
        while (-1 !== ($ch = $this->iCurrentChar)) {
            if ('<' === $ch) {
                return $sb;
            }
            $sb .= $ch;
            $this->moveNext();
        }

        return $sb;
    }

    /**
     * Returns text between current position and $needle,
     * inclusive, or "" if not found. The current index is moved to a point
     * after the location of $needle, or not moved at all
     * if nothing is found.
     * @param $needle
     */
    public function skipToStringInTag($needle): string
    {
        $pos = \mb_strpos($this->iHtmlText, $needle, $this->iHtmlTextIndex);
        if (false === $pos) {
            return '';
        }
        $top      = $pos + \mb_strlen($needle);
        $retvalue = \mb_substr($this->iHtmlText, $this->iHtmlTextIndex, $top - $this->iHtmlTextIndex);
        $this->setTextIndex($top);

        return $retvalue;
    }
}

/**
 * @param $fileName
 * @return HtmlParser
 */
function HtmlParser_ForFile($fileName)
{
    return new HtmlParser(file_get_contents($filename));
}

/**
 * @param $url
 * @return HtmlParser
 */
function HtmlParser_ForURL($url)
{
    $fp      = \fopen($url, 'rb');
    $content = '';
    while (true) {
        $data = \fread($fp, 8192);
        if ('' === $data) {
            break;
        }
        $content .= $data;
    }
    \fclose($fp);

    return new HtmlParser($content);
}
