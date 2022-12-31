<?php declare(strict_types=1);

namespace XoopsModules\Wfchannel;

/**
 * Website: https://sourceforge.net/projects/simplehtmldom/
 * Additional projects that may be used: https://sourceforge.net/projects/debugobject/
 * Acknowledge: Jose Solorzano (https://sourceforge.net/projects/php-html/)
 * Contributions by:
 *   Yousuke Kumakura (Attribute filters)
 *   Vadim Voituk (Negative indexes supports of "find" method)
 *   Antcs (Constructor with automatically load contents either text or file/url)
 *
 * all affected sections have comments starting with "PaperG"
 *
 * Paperg - Added case insensitive testing of the value of the selector.
 * Paperg - Added tag_start for the starting index of tags - NOTE: This works but not accurately.
 *  This tag_start gets counted AFTER \r\n have been crushed out, and after the remove_noice calls so it will not reflect the REAL position of the tag in the source,
 *  it will almost always be smaller by some amount.
 *  We use this to determine how far into the file the tag in question is.  This "percentage will never be accurate as the $dom->size is the "real" number of bytes the dom was created from.
 *  but for most purposes, it's a really good estimation.
 * Paperg - Added the forceTagsClosed to the dom constructor.  Forcing tags closed is great for malformed html, but it CAN lead to parsing errors.
 * Allow the user to tell us how much they trust the html.
 * Paperg add the text and plaintext to the selectors for the find syntax.  plaintext implies text in the innertext of a node.  text implies that the tag is a text node.
 * This allows for us to find tags based on the text they contain.
 * Create find_ancestor_tag to see if a tag is - at any level - inside of another specific tag.
 * Paperg: added parse_charset so that we know about the character set of the source document.
 *  NOTE:  If the user's system has a routine called get_last_retrieve_url_contents_content_type availalbe, we will assume it's returning the content-type header from the
 *  last transfer or curl_exec, and we will parse that and use it in preference to any other method of charset detection.
 *
 * Found infinite loop in the case of broken html in restore_noise.  Rewrote to protect from that.
 * PaperG (John Schlick) Added get_display_size for "IMG" tags.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author     S.C. Chen <me578022@gmail.com>
 * @author     John Schlick
 * @author     Rus Carroll
 */

/**
 * All of the Defines for the classes below.
 * @author S.C. Chen <me578022@gmail.com>
 */
\define('HDOM_TYPE_ELEMENT', 1);
\define('HDOM_TYPE_COMMENT', 2);
\define('HDOM_TYPE_TEXT', 3);
\define('HDOM_TYPE_ENDTAG', 4);
\define('HDOM_TYPE_ROOT', 5);
\define('HDOM_TYPE_UNKNOWN', 6);
\define('HDOM_QUOTE_DOUBLE', 0);
\define('HDOM_QUOTE_SINGLE', 1);
\define('HDOM_QUOTE_NO', 3);
\define('HDOM_INFO_BEGIN', 0);
\define('HDOM_INFO_END', 1);
\define('HDOM_INFO_QUOTE', 2);
\define('HDOM_INFO_SPACE', 3);
\define('HDOM_INFO_TEXT', 4);
\define('HDOM_INFO_INNER', 5);
\define('HDOM_INFO_OUTER', 6);
\define('HDOM_INFO_ENDSPACE', 7);
\define('DEFAULT_TARGET_CHARSET', 'UTF-8');
\define('DEFAULT_BR_TEXT', "\r\n");
\define('DEFAULT_SPAN_TEXT', ' ');
\define('MAX_FILE_SIZE', 600000);
// helper functions
// -----------------------------------------------------------------------------
// get html dom from file
// $maxlen is defined in the code as PHP_STREAM_COPY_ALL which is defined as -1.
/**
 * @param                       $url
 * @param bool|false            $use_include_path
 * @param null                  $context
 * @param int                   $offset
 * @param int                   $maxLen
 * @param bool|true             $lowercase
 * @param bool|true             $forceTagsClosed
 * @param string                $target_charset
 * @param bool|true             $stripRN
 * @param string                $defaultBRText
 * @param string                $defaultSpanText
 * @return bool|simple_html_dom
 */
function file_get_html(
    $url,
    $use_include_path = false,
    $context = null,
    $offset = -1,
    $maxLen = -1,
    $lowercase = true,
    $forceTagsClosed = true,
    $target_charset = DEFAULT_TARGET_CHARSET,
    $stripRN = true,
    $defaultBRText = DEFAULT_BR_TEXT,
    $defaultSpanText = DEFAULT_SPAN_TEXT
) {
    // We DO force the tags to be terminated.
    $dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
    // For sourceforge users: uncomment the next line and comment the retreive_url_contents line 2 lines down if it is not already done.
    $contents = file_get_contents($url, $use_include_path, $context, $offset);
    // Paperg - use our own mechanism for getting the contents as we want to control the timeout.
    //$contents = retrieve_url_contents($url);
    if (empty($contents) || mb_strlen($contents) > MAX_FILE_SIZE) {
        return false;
    }
    // The second parameter can force the selectors to all be lowercase.
    $dom->load($contents, $lowercase, $stripRN);

    return $dom;
}

// get html dom from string
/**
 * @param                       $str
 * @param bool|true             $lowercase
 * @param bool|true             $forceTagsClosed
 * @param string                $target_charset
 * @param bool|true             $stripRN
 * @param string                $defaultBRText
 * @param string                $defaultSpanText
 * @return bool|simple_html_dom
 */
function str_get_html(
    $str,
    $lowercase = true,
    $forceTagsClosed = true,
    $target_charset = DEFAULT_TARGET_CHARSET,
    $stripRN = true,
    $defaultBRText = DEFAULT_BR_TEXT,
    $defaultSpanText = DEFAULT_SPAN_TEXT
) {
    $dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
    if (empty($str) || mb_strlen($str) > MAX_FILE_SIZE) {
        $dom->clear();

        return false;
    }
    $dom->load($str, $lowercase, $stripRN);

    return $dom;
}

// dump html dom tree
/**
 * @param           $node
 * @param bool|true $show_attr
 * @param int       $deep
 */
function dump_html_tree($node, $show_attr = true, $deep = 0): void
{
    $node->dump($node);
}

/**
 * simple html dom node
 * PaperG - added ability for "find" routine to lowercase the value of the selector.
 * PaperG - added $tag_start to track the start position of the tag in the total byte index
 */
class simple_html_dom_node
{
    public $nodetype = HDOM_TYPE_TEXT;
    public $tag      = 'text';
    public $attr     = [];
    public $children = [];
    public $nodes    = [];
    public $parent   = null;
    // The "info" array - see HDOM_INFO_... for what each element contains.
    public  $_         = [];
    public  $tag_start = 0;
    private $dom       = null;

    /**
     * @param $dom
     */
    public function __construct($dom)
    {
        $this->dom    = $dom;
        $dom->nodes[] = $this;
    }

    public function __destruct()
    {
        $this->clear();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->outertext();
    }

    // clean up memory due to php5 circular references memory leak...
    public function clear(): void
    {
        $this->dom      = null;
        $this->nodes    = null;
        $this->parent   = null;
        $this->children = null;
    }

    // dump node's tree

    /**
     * @param bool|true $show_attr
     * @param int       $deep
     */
    public function dump($show_attr = true, $deep = 0): void
    {
        $lead = \str_repeat('    ', $deep);

        echo $lead . $this->tag;
        if ($show_attr && \count($this->attr) > 0) {
            echo '(';
            foreach ($this->attr as $k => $v) {
                echo "[$k]=>\"" . $this->$k . '", ';
            }
            echo ')';
        }
        echo "\n";

        if ($this->nodes) {
            foreach ($this->nodes as $c) {
                $c->dump($show_attr, $deep + 1);
            }
        }
    }

    // Debugging function to dump a single dom node with a bunch of information about it.

    /**
     * @param bool|true $echo
     * @return string|void
     */
    public function dump_node($echo = true)
    {
        $string = $this->tag;
        if (\count($this->attr) > 0) {
            $string .= '(';
            foreach ($this->attr as $k => $v) {
                $string .= "[$k]=>\"" . $this->$k . '", ';
            }
            $string .= ')';
        }
        if (\count($this->_) > 0) {
            $string .= ' $_ (';
            foreach ($this->_ as $k => $v) {
                if (\is_array($v)) {
                    $string .= "[$k]=>(";
                    foreach ($v as $k2 => $v2) {
                        $string .= "[$k2]=>\"" . $v2 . '", ';
                    }
                    $string .= ')';
                } else {
                    $string .= "[$k]=>\"" . $v . '", ';
                }
            }
            $string .= ')';
        }

        if (isset($this->text)) {
            $string .= ' text: (' . $this->text . ')';
        }

        $string .= " HDOM_INNER_INFO: '";
        if (isset($node->_[HDOM_INFO_INNER])) {
            $string .= $node->_[HDOM_INFO_INNER] . "'";
        } else {
            $string .= ' NULL ';
        }

        $string .= ' children: ' . \count($this->children);
        $string .= ' nodes: ' . \count($this->nodes);
        $string .= ' tag_start: ' . $this->tag_start;
        $string .= "\n";

        if ($echo) {
            echo $string;

            return;
        }

        return $string;
    }

    // returns the parent of node
    // If a node is passed in, it will reset the parent of the current node to that one.

    /**
     * @param null $parent
     */
    public function parent($parent = null)
    {
        // I am SURE that this doesn't work properly.
        // It fails to unset the current node from it's current parents nodes or children list first.
        if (null !== $parent) {
            $this->parent             = $parent;
            $this->parent->nodes[]    = $this;
            $this->parent->children[] = $this;
        }

        return $this->parent;
    }

    // verify that node has children

    /**
     * @return bool
     */
    public function has_child()
    {
        return !empty($this->children);
    }

    // returns children of node

    /**
     * @param int $idx
     */
    public function children($idx = -1): ?array
    {
        if (-1 === $idx) {
            return $this->children;
        }

        return $this->children[$idx] ?? null;
    }

    // returns the first child of node

    /**
     * @return mixed|null
     */
    public function first_child()
    {
        if (\count($this->children) > 0) {
            return $this->children[0];
        }

        return null;
    }

    // returns the last child of node

    /**
     * @return mixed|null
     */
    public function last_child()
    {
        if (($count = \count($this->children)) > 0) {
            return $this->children[$count - 1];
        }

        return null;
    }

    // returns the next sibling of node

    /**
     * @return mixed|null
     */
    public function next_sibling()
    {
        if (null === $this->parent) {
            return null;
        }

        $idx   = 0;
        $count = \count($this->parent->children);
        while ($idx < $count && $this !== $this->parent->children[$idx]) {
            ++$idx;
        }
        if (++$idx >= $count) {
            return null;
        }

        return $this->parent->children[$idx];
    }

    // returns the previous sibling of node

    /**
     * @return mixed|null
     */
    public function prev_sibling()
    {
        if (null === $this->parent) {
            return null;
        }
        $idx   = 0;
        $count = \count($this->parent->children);
        while ($idx < $count && $this !== $this->parent->children[$idx]) {
            ++$idx;
        }
        if (--$idx < 0) {
            return null;
        }

        return $this->parent->children[$idx];
    }

    // function to locate a specific ancestor tag in the path to the root.

    /**
     * @param $tag
     */
    public function find_ancestor_tag($tag): ?self
    {
        global $debug_object;
        if (\is_object($debug_object)) {
            $debug_object->debug_log_entry(1);
        }

        // Start by including ourselves in the comparison.
        $returnDom = $this;

        while (null !== $returnDom) {
            if (\is_object($debug_object)) {
                $debug_object->debug_log(2, 'Current tag is: ' . $returnDom->tag);
            }

            if ($returnDom->tag === $tag) {
                break;
            }
            $returnDom = $returnDom->parent;
        }

        return $returnDom;
    }

    // get dom node's inner html

    public function innertext(): string
    {
        if (isset($this->_[HDOM_INFO_INNER])) {
            return $this->_[HDOM_INFO_INNER];
        }
        if (isset($this->_[HDOM_INFO_TEXT])) {
            return $this->dom->restore_noise($this->_[HDOM_INFO_TEXT]);
        }

        $ret = '';
        foreach ($this->nodes as $n) {
            $ret .= $n->outertext();
        }

        return $ret;
    }

    // get dom node's outer text (with tag)

    public function outertext(): string
    {
        global $debug_object;
        if (\is_object($debug_object)) {
            $text = '';
            if ('text' === $this->tag) {
                if ('' !== $this->text) {
                    $text = ' with text: ' . $this->text;
                }
            }
            $debug_object->debug_log(1, 'Innertext of tag: ' . $this->tag . $text);
        }

        if ('root' === $this->tag) {
            return $this->innertext();
        }

        // trigger callback
        if ($this->dom && null !== $this->dom->callback) {
            \call_user_func($this->dom->callback, [$this]);
        }

        if (isset($this->_[HDOM_INFO_OUTER])) {
            return $this->_[HDOM_INFO_OUTER];
        }
        if (isset($this->_[HDOM_INFO_TEXT])) {
            return $this->dom->restore_noise($this->_[HDOM_INFO_TEXT]);
        }

        // render begin tag
        $ret = '';
        if ($this->dom && $this->dom->nodes[$this->_[HDOM_INFO_BEGIN]]) {
            $ret = $this->dom->nodes[$this->_[HDOM_INFO_BEGIN]]->makeup();
        }

        // render inner text
        if (isset($this->_[HDOM_INFO_INNER])) {
            // If it's a br tag...  don't return the HDOM_INNER_INFO that we may or may not have added.
            if ('br' !== $this->tag) {
                $ret .= $this->_[HDOM_INFO_INNER];
            }
        } else {
            if ($this->nodes) {
                foreach ($this->nodes as $n) {
                    $ret .= $this->convert_text($n->outertext());
                }
            }
        }

        // render end tag
        if (isset($this->_[HDOM_INFO_END]) && 0 !== $this->_[HDOM_INFO_END]) {
            $ret .= '</' . $this->tag . '>';
        }

        return $ret;
    }

    // get dom node's plain text

    public function text(): string
    {
        if (isset($this->_[HDOM_INFO_INNER])) {
            return $this->_[HDOM_INFO_INNER];
        }
        switch ($this->nodetype) {
            case HDOM_TYPE_TEXT:
                return $this->dom->restore_noise($this->_[HDOM_INFO_TEXT]);
            case HDOM_TYPE_COMMENT:
                return '';
            case HDOM_TYPE_UNKNOWN:
                return '';
        }
        if (0 === \strcasecmp($this->tag, 'script')) {
            return '';
        }
        if (0 === \strcasecmp($this->tag, 'style')) {
            return '';
        }

        $ret = '';
        // In rare cases, (always node type 1 or HDOM_TYPE_ELEMENT - observed for some span tags, and some p tags) $this->nodes is set to NULL.
        // NOTE: This indicates that there is a problem where it's set to NULL without a clear happening.
        // WHY is this happening?
        if (null !== $this->nodes) {
            foreach ($this->nodes as $n) {
                $ret .= $this->convert_text($n->text());
            }

            // If this node is a span... add a space at the end of it so multiple spans don't run into each other.  This is plaintext after all.
            if ('span' === $this->tag) {
                $ret .= $this->dom->default_span_text;
            }
        }

        return $ret;
    }

    /**
     * @return array|string|string[]
     */
    public function xmltext()
    {
        $ret = $this->innertext();
        $ret = \str_ireplace('<![CDATA[', '', $ret);
        $ret = \str_replace(']]>', '', $ret);

        return $ret;
    }

    // build node's text with tag

    public function makeup(): string
    {
        // text, comment, unknown
        if (isset($this->_[HDOM_INFO_TEXT])) {
            return $this->dom->restore_noise($this->_[HDOM_INFO_TEXT]);
        }

        $ret = '<' . $this->tag;
        $i   = -1;

        foreach ($this->attr as $key => $val) {
            ++$i;

            // skip removed attribute
            if (null === $val || false === $val) {
                continue;
            }

            $ret .= $this->_[HDOM_INFO_SPACE][$i][0];
            //no value attr: nowrap, checked selected...
            if (true === $val) {
                $ret .= $key;
            } else {
                switch ($this->_[HDOM_INFO_QUOTE][$i]) {
                    case HDOM_QUOTE_DOUBLE:
                        $quote = '"';
                        break;
                    case HDOM_QUOTE_SINGLE:
                        $quote = '\'';
                        break;
                    default:
                        $quote = '';
                }
                $ret .= $key . $this->_[HDOM_INFO_SPACE][$i][1] . '=' . $this->_[HDOM_INFO_SPACE][$i][2] . $quote . $val . $quote;
            }
        }
        $ret = $this->dom->restore_noise($ret);

        return $ret . $this->_[HDOM_INFO_ENDSPACE] . '>';
    }

    // find elements by css selector
    //PaperG - added ability for find to lowercase the value of the selector.

    /**
     * @param             $selector
     * @param null        $idx
     * @param bool|false  $lowercase
     */
    public function find($selector, $idx = null, $lowercase = false): ?array
    {
        $selectors = $this->parse_selector($selector);
        if (0 === ($count = \count($selectors))) {
            return [];
        }
        $found_keys = [];

        // find each selector
        for ($c = 0; $c < $count; ++$c) {
            // The change on the below line was documented on the sourceforge code tracker id 2788009
            // used to be: if (($levle=count($selectors[0]))===0) return array();
            if (0 === ($levle = \count($selectors[$c]))) {
                return [];
            }
            if (!isset($this->_[HDOM_INFO_BEGIN])) {
                return [];
            }

            $head = [$this->_[HDOM_INFO_BEGIN] => 1];

            // handle descendant selectors, no recursive!
            for ($l = 0; $l < $levle; ++$l) {
                $ret = [];
                foreach ($head as $k => $v) {
                    $n = (-1 === $k) ? $this->dom->root : $this->dom->nodes[$k];
                    //PaperG - Pass this optional parameter on to the seek function.
                    $n->seek($selectors[$c][$l], $ret, $lowercase);
                }
                $head = $ret;
            }

            foreach ($head as $k => $v) {
                if (!isset($found_keys[$k])) {
                    $found_keys[$k] = 1;
                }
            }
        }

        // sort keys
        \ksort($found_keys);

        $found = [];
        foreach ($found_keys as $k => $v) {
            $found[] = $this->dom->nodes[$k];
        }

        // return nth-element or array
        if (null === $idx) {
            return $found;
        }

        if ($idx < 0) {
            $idx = \count($found) + $idx;
        }

        return $found[$idx] ?? null;
    }

    // seek for given conditions
    // PaperG - added parameter to allow for case insensitive testing of the value of a selector.

    /**
     * @param            $selector
     * @param bool|false $lowercase
     */
    protected function seek($selector, &$ret, $lowercase = false): void
    {
        global $debug_object;
        if (\is_object($debug_object)) {
            $debug_object->debug_log_entry(1);
        }

        [$tag, $key, $val, $exp, $no_key] = $selector;

        // xpath index
        if ($tag && $key && \is_numeric($key)) {
            $count = 0;
            foreach ($this->children as $c) {
                if ('*' === $tag || $tag === $c->tag) {
                    if (++$count === $key) {
                        $ret[$c->_[HDOM_INFO_BEGIN]] = 1;

                        return;
                    }
                }
            }

            return;
        }

        $end = !empty($this->_[HDOM_INFO_END]) ? $this->_[HDOM_INFO_END] : 0;
        if (0 === $end) {
            $parent = $this->parent;
            while (!isset($parent->_[HDOM_INFO_END]) && null !== $parent) {
                --$end;
                $parent = $parent->parent;
            }
            $end += $parent->_[HDOM_INFO_END];
        }

        for ($i = $this->_[HDOM_INFO_BEGIN] + 1; $i < $end; ++$i) {
            $node = $this->dom->nodes[$i];

            $pass = true;

            if ('*' === $tag && !$key) {
                if (\in_array($node, $this->children, true)) {
                    $ret[$i] = 1;
                }
                continue;
            }

            // compare tag
            if ($tag && $tag != $node->tag && '*' !== $tag) {
                $pass = false;
            }
            // compare key
            if ($pass && $key) {
                if ($no_key) {
                    if (isset($node->attr[$key])) {
                        $pass = false;
                    }
                } else {
                    if (('plaintext' !== $key) && !isset($node->attr[$key])) {
                        $pass = false;
                    }
                }
            }
            // compare value
            if ($pass && $key && $val && '*' !== $val) {
                // If they have told us that this is a "plaintext" search then we want the plaintext of the node - right?
                if ('plaintext' === $key) {
                    // $node->plaintext actually returns $node->text();
                    $nodeKeyValue = $node->text();
                } else {
                    // this is a normal search, we want the value of that attribute of the tag.
                    $nodeKeyValue = $node->attr[$key];
                }
                if (\is_object($debug_object)) {
                    $debug_object->debug_log(2, 'testing node: ' . $node->tag . ' for attribute: ' . $key . $exp . $val . ' where nodes value is: ' . $nodeKeyValue);
                }

                //PaperG - If lowercase is set, do a case insensitive test of the value of the selector.
                if ($lowercase) {
                    $check = $this->getMatch($exp, \mb_strtolower($val), \mb_strtolower($nodeKeyValue));
                } else {
                    $check = $this->getMatch($exp, $val, $nodeKeyValue);
                }
                if (\is_object($debug_object)) {
                    $debug_object->debug_log(2, 'after match: ' . ($check ? 'true' : 'false'));
                }

                // handle multiple class
                if (!$check && 0 === \strcasecmp($key, 'class')) {
                    foreach (\explode(' ', $node->attr[$key]) as $k) {
                        // Without this, there were cases where leading, trailing, or double spaces lead to our comparing blanks - bad form.
                        if (!empty($k)) {
                            if ($lowercase) {
                                $check = $this->getMatch($exp, \mb_strtolower($val), \mb_strtolower($k));
                            } else {
                                $check = $this->getMatch($exp, $val, $k);
                            }
                            if ($check) {
                                break;
                            }
                        }
                    }
                }
                if (!$check) {
                    $pass = false;
                }
            }
            if ($pass) {
                $ret[$i] = 1;
            }
            unset($node);
        }
        // It's passed by reference so this is actually what this function returns.
        if (\is_object($debug_object)) {
            $debug_object->debug_log(1, 'EXIT - ret: ', $ret);
        }
    }

    /**
     * @param $exp
     * @param $pattern
     * @param $value
     * @return bool|int
     */
    protected function getMatch($exp, $pattern, $value)
    {
        global $debug_object;
        if (\is_object($debug_object)) {
            $debug_object->debug_log_entry(1);
        }

        switch ($exp) {
            case '=':
                return ($value === $pattern);
            case '!=':
                return ($value !== $pattern);
            case '^=':
                return \preg_match('/^' . preg_quote($pattern, '/') . '/', $value);
            case '$=':
                return \preg_match('/' . preg_quote($pattern, '/') . '$/', $value);
            case '*=':
                if ('/' === $pattern[0]) {
                    return \preg_match($pattern, $value);
                }

                return \preg_match('/' . $pattern . '/i', $value);
        }

        return false;
    }

    /**
     * @param $selector_string
     */
    protected function parse_selector($selector_string): array
    {
        global $debug_object;
        if (\is_object($debug_object)) {
            $debug_object->debug_log_entry(1);
        }

        // pattern of CSS selectors, modified from mootools
        // Paperg: Add the colon to the attrbute, so that it properly finds <tag attr:ibute="something" > like google does.
        // Note: if you try to look at this attribute, yo MUST use getAttribute since $dom->x:y will fail the php syntax check.
        // Notice the \[ starting the attbute?  and the @? following?  This implies that an attribute can begin with an @ sign that is not captured.
        // This implies that an html attribute specifier may start with an @ sign that is NOT captured by the expression.
        // farther study is required to determine of this should be documented or removed.
        //      $pattern = "/([\w-:\*]*)(?:\#([\w-]+)|\.([\w-]+))?(?:\[@?(!?[\w-]+)(?:([!*^$]?=)[\"']?(.*?)[\"']?)?\])?([\/, ]+)/is";
        $pattern = "/([\w-:\*]*)(?:\#([\w-]+)|\.([\w-]+))?(?:\[@?(!?[\w-:]+)(?:([!*^$]?=)[\"']?(.*?)[\"']?)?\])?([\/, ]+)/is";
        \preg_match_all($pattern, \trim($selector_string) . ' ', $matches, \PREG_SET_ORDER);
        if (\is_object($debug_object)) {
            $debug_object->debug_log(2, 'Matches Array: ', $matches);
        }

        $selectors = [];
        $result    = [];
        //print_r($matches);

        foreach ($matches as $m) {
            $m[0] = \trim($m[0]);
            if ('' === $m[0] || '/' === $m[0] || '//' === $m[0]) {
                continue;
            }
            // for browser generated xpath
            if ('tbody' === $m[1]) {
                continue;
            }

            [$tag, $key, $val, $exp, $no_key] = [$m[1], null, null, '=', false];
            if (!empty($m[2])) {
                $key = 'id';
                $val = $m[2];
            }
            if (!empty($m[3])) {
                $key = 'class';
                $val = $m[3];
            }
            if (!empty($m[4])) {
                $key = $m[4];
            }
            if (!empty($m[5])) {
                $exp = $m[5];
            }
            if (!empty($m[6])) {
                $val = $m[6];
            }

            // convert to lowercase
            if ($this->dom->lowercase) {
                $tag = \mb_strtolower($tag);
                $key = \mb_strtolower($key);
            }
            //elements that do NOT have the specified attribute
            if (isset($key[0]) && '!' === $key[0]) {
                $key    = mb_substr($key, 1);
                $no_key = true;
            }

            $result[] = [$tag, $key, $val, $exp, $no_key];
            if (',' === \trim($m[7])) {
                $selectors[] = $result;
                $result      = [];
            }
        }
        if (\count($result) > 0) {
            $selectors[] = $result;
        }

        return $selectors;
    }

    /**
     * @param $name
     * @return bool|mixed|string
     */
    public function __get($name)
    {
        if (isset($this->attr[$name])) {
            return $this->convert_text($this->attr[$name]);
        }
        switch ($name) {
            case 'outertext':
                return $this->outertext();
            case 'innertext':
                return $this->innertext();
            case 'plaintext':
                return $this->text();
            case 'xmltext':
                return $this->xmltext();
            default:
                return \array_key_exists($name, $this->attr);
        }
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        global $debug_object;
        if (\is_object($debug_object)) {
            $debug_object->debug_log_entry(1);
        }

        switch ($name) {
            case 'outertext':
                return $this->_[HDOM_INFO_OUTER] = $value;
            case 'innertext':
                if (isset($this->_[HDOM_INFO_TEXT])) {
                    return $this->_[HDOM_INFO_TEXT] = $value;
                }

                return $this->_[HDOM_INFO_INNER] = $value;
        }
        if (!isset($this->attr[$name])) {
            $this->_[HDOM_INFO_SPACE][] = [' ', '', ''];
            $this->_[HDOM_INFO_QUOTE][] = HDOM_QUOTE_DOUBLE;
        }
        $this->attr[$name] = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        switch ($name) {
            case 'outertext':
                return true;
            case 'innertext':
                return true;
            case 'plaintext':
                return true;
        }

        //no value attr: nowrap, checked selected...
        return \array_key_exists($name, $this->attr) ? true : isset($this->attr[$name]);
    }

    /**
     * @param $name
     */
    public function __unset($name): void
    {
        if (isset($this->attr[$name])) {
            unset($this->attr[$name]);
        }
    }

    // PaperG - Function to convert the text from one character set to another if the two sets are not the same.

    /**
     * @param $text
     */
    public function convert_text($text): string
    {
        global $debug_object;
        if (\is_object($debug_object)) {
            $debug_object->debug_log_entry(1);
        }

        $converted_text = $text;

        $sourceCharset = '';
        $targetCharset = '';

        if ($this->dom) {
            $sourceCharset = \mb_strtoupper($this->dom->_charset);
            $targetCharset = \mb_strtoupper($this->dom->_target_charset);
        }
        if (\is_object($debug_object)) {
            $debug_object->debug_log(3, 'source charset: ' . $sourceCharset . ' target charaset: ' . $targetCharset);
        }

        if (!empty($sourceCharset) && !empty($targetCharset) && (0 !== \strcasecmp($sourceCharset, $targetCharset))) {
            // Check if the reported encoding could have been incorrect and the text is actually already UTF-8
            if ((0 === \strcasecmp($targetCharset, 'UTF-8')) && static::is_utf8($text)) {
                $converted_text = $text;
            } else {
                $converted_text = \iconv($sourceCharset, $targetCharset, $text);
            }
        }

        // Lets make sure that we don't have that silly BOM issue with any of the utf-8 text we output.
        if ('UTF-8' === $targetCharset) {
            if (0 === mb_strpos($converted_text, "\xef\xbb\xbf")) {
                $converted_text = mb_substr($converted_text, 3);
            }
            if ("\xef\xbb\xbf" === mb_substr($converted_text, -3)) {
                $converted_text = mb_substr($converted_text, 0, -3);
            }
        }

        return $converted_text;
    }

    /**
     * Returns true if $string is valid UTF-8 and false otherwise.
     *
     * @param mixed $str String to be tested
     * @return bool
     */
    public static function is_utf8($str)
    {
        $c    = 0;
        $b    = 0;
        $bits = 0;
        $len  = mb_strlen($str);
        for ($i = 0; $i < $len; ++$i) {
            $c = \ord($str[$i]);
            if ($c > 128) {
                if ($c >= 254) {
                    return false;
                }

                if ($c >= 252) {
                    $bits = 6;
                } elseif ($c >= 248) {
                    $bits = 5;
                } elseif ($c >= 240) {
                    $bits = 4;
                } elseif ($c >= 224) {
                    $bits = 3;
                } elseif ($c >= 192) {
                    $bits = 2;
                } else {
                    return false;
                }
                if (($i + $bits) > $len) {
                    return false;
                }
                while ($bits > 1) {
                    $i++;
                    $b = \ord($str[$i]);
                    if ($b < 128 || $b > 191) {
                        return false;
                    }
                    $bits--;
                }
            }
        }

        return true;
    }

    /*
    function is_utf8($string)
    {
        //this is buggy
        return (xoops_utf8_encode(utf8_decode($string)) == $string);
    }
    */

    /**
     * Function to try a few tricks to determine the displayed size of an img on the page.
     * NOTE: This will ONLY work on an IMG tag. Returns FALSE on all other tag types.
     *
     * @return array|bool an array containing the 'height' and 'width' of the image on the page or -1 if we can't figure it out.
     * @author  John Schlick
     */
    public function get_display_size()
    {
        global $debug_object;

        $width  = -1;
        $height = -1;

        if ('img' !== $this->tag) {
            return false;
        }

        // See if there is aheight or width attribute in the tag itself.
        if (isset($this->attr['width'])) {
            $width = $this->attr['width'];
        }

        if (isset($this->attr['height'])) {
            $height = $this->attr['height'];
        }

        // Now look for an inline style.
        if (isset($this->attr['style'])) {
            // Thanks to user gnarf from stackoverflow for this regular expression.
            $attributes = [];
            \preg_match_all('/([\w-]+)\s*:\s*([^;]+)\s*;?/', $this->attr['style'], $matches, \PREG_SET_ORDER);
            foreach ($matches as $match) {
                $attributes[$match[1]] = $match[2];
            }

            // If there is a width in the style attributes:
            if (isset($attributes['width']) && -1 === $width) {
                // check that the last two characters are px (pixels)
                if ('px' === \mb_strtolower(mb_substr($attributes['width'], -2))) {
                    $proposed_width = mb_substr($attributes['width'], 0, -2);
                    // Now make sure that it's an integer and not something stupid.
                    if (\filter_var($proposed_width, \FILTER_VALIDATE_INT)) {
                        $width = $proposed_width;
                    }
                }
            }

            // If there is a width in the style attributes:
            if (isset($attributes['height']) && -1 === $height) {
                // check that the last two characters are px (pixels)
                if ('px' === \mb_strtolower(mb_substr($attributes['height'], -2))) {
                    $proposed_height = mb_substr($attributes['height'], 0, -2);
                    // Now make sure that it's an integer and not something stupid.
                    if (\filter_var($proposed_height, \FILTER_VALIDATE_INT)) {
                        $height = $proposed_height;
                    }
                }
            }
        }

        // Future enhancement:
        // Look in the tag to see if there is a class or id specified that has a height or width attribute to it.

        // Far future enhancement
        // Look at all the parent tags of this image to see if they specify a class or id that has an img selector that specifies a height or width
        // Note that in this case, the class or id will have the img subselector for it to apply to the image.

        // ridiculously far future development
        // If the class or id is specified in a SEPARATE css file thats not on the page, go get it and do what we were just doing for the ones on the page.

        $result = [
            'height' => $height,
            'width'  => $width,
        ];

        return $result;
    }

    // camel naming conventions

    public function getAllAttributes(): array
    {
        return $this->attr;
    }

    /**
     * @param $name
     * @return bool|mixed|string
     */
    public function getAttribute($name)
    {
        return $this->__get($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function setAttribute($name, $value): void
    {
        $this->__set($name, $value);
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        return $this->__isset($name);
    }

    /**
     * @param $name
     */
    public function removeAttribute($name): void
    {
        $this->__set($name, null);
    }

    /**
     * @param $id
     */
    public function getElementById($id): ?array
    {
        return $this->find("#$id", 0);
    }

    /**
     * @param             $id
     * @param null        $idx
     */
    public function getElementsById($id, $idx = null): ?array
    {
        return $this->find("#$id", $idx);
    }

    /**
     * @param $name
     */
    public function getElementByTagName($name): ?array
    {
        return $this->find($name, 0);
    }

    /**
     * @param             $name
     * @param null        $idx
     */
    public function getElementsByTagName($name, $idx = null): ?array
    {
        return $this->find($name, $idx);
    }

    public function parentNode()
    {
        return $this->parent();
    }

    /**
     * @param int $idx
     */
    public function childNodes($idx = -1): ?array
    {
        return $this->children($idx);
    }

    /**
     * @return mixed|null
     */
    public function firstChild()
    {
        return $this->first_child();
    }

    /**
     * @return mixed|null
     */
    public function lastChild()
    {
        return $this->last_child();
    }

    /**
     * @return mixed|null
     */
    public function nextSibling()
    {
        return $this->next_sibling();
    }

    /**
     * @return mixed|null
     */
    public function previousSibling()
    {
        return $this->prev_sibling();
    }

    /**
     * @return bool
     */
    public function hasChildNodes()
    {
        return $this->has_child();
    }

    public function nodeName(): string
    {
        return $this->tag;
    }

    /**
     * @param $node
     * @return mixed
     */
    public function appendChild($node)
    {
        $node->parent($this);

        return $node;
    }
}
