<?php declare(strict_types=1);

namespace XoopsModules\Wfchannel;

/**
 * Name: class.page.php
 * Description:
 *
 * @Module     : WF-Channel
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use Xmf\Request;
use XoopsModules\Wfresource;

/**
 * Include resource classes
 */
//wfp_getObjectHandler();

/**
 * Page
 *
 * @author    John
 * @copyright Copyright (c) 2009
 */
class Page extends Wfresource\WfpObject
{
//    private $wfc_cid;
//    private $wfc_title;
//    private $wfc_headline;
//    private $wfc_content;
//    private $wfc_weight;
//    private $wfc_default;
//    private $wfc_image;
//    private $wfc_file;
//    private $wfc_usefiletitle;
//    private $wfc_created;
//    private $wfc_publish;
//    private $wfc_expired;
//    private $wfc_mainmenu;
//    private $wfc_submenu;
//    private $wfc_counter;
//    private $wfc_comments;
//    private $wfc_allowcomments;
//    private $wfc_uid;
//    private $wfc_metakeywords;
//    private $wfc_metadescription;
//    private $wfc_related;
//    private $wfc_author;
//    private $wfc_caption;
//    private $wfc_active;
//    // **//
//    private $dohtml;
//    private $doxcode;
//    private $dosmiley;
//    private $doimage;
//    private $dobr;

    public $content;
    public $pageNav;
    public $uploadDir;
    public $related;

    /**
     * XoopsWfPage::XoopsWfPage()
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('wfc_cid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfc_title', \XOBJ_DTYPE_TXTBOX, null, true, 120);
        $this->initVar('wfc_headline', \XOBJ_DTYPE_TXTBOX, null, false, 150);
        $this->initVar('wfc_content', \XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('wfc_weight', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_default', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_image', \XOBJ_DTYPE_TXTBOX, '||', false, 250);
        $this->initVar('wfc_file', \XOBJ_DTYPE_TXTBOX, '', false, 250);
        $this->initVar('wfc_usefiletitle', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_created', \XOBJ_DTYPE_INT, \time(), false);
        $this->initVar('wfc_publish', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfc_expired', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfc_mainmenu', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('wfc_submenu', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('wfc_counter', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_comments', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_allowcomments', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('wfc_uid', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_metakeywords', \XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('wfc_metadescription', \XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('wfc_related', \XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('wfc_author', \XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('wfc_caption', \XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('wfc_active', \XOBJ_DTYPE_INT, 1, false);
        // **//
        $this->initVar('dohtml', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('doxcode', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('dosmiley', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('doimage', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('dobr', \XOBJ_DTYPE_INT, 1, false);

        $this->uploadDir = $GLOBALS['xoopsModuleConfig']['htmluploaddir'];
    }

    /**
     * Page::getIcons()
     */
    public function getIcons(): array
    {
        $iconArray = Wfresource\Utility::getModuleOption('pageicon');
        $flipped   = \array_flip($iconArray);

        $iconVars = [0 => 'none', 1 => 'rss', 2 => 'print', 3 => 'pdf', 4 => 'email', 5 => 'bookmark'];
        $ret      = [];
        foreach ($iconVars as $k => $v) {
            if (!isset($flipped[0])) {
                $ret[$v] = isset($flipped[$k]) ? 1 : 0;
            }
        }

        return $ret;
    }

    /**
     * Page::getUserName()
     *
     * @param mixed  $value
     * @param string $timestamp
     * @param mixed  $usereal
     * @param mixed  $linked
     * @return mixed|string
     */
    public function getUserName($value, $timestamp = '', $usereal = false, $linked = false)
    {
        if ($this->getVar('wfc_author')) {
            return $this->getVar('wfc_author');
        }

        return parent::getUserName($value, $timestamp = '', $usereal = false, $linked = false);
    }

    /**
     * Page::getTitle()
     * @return mixed|string
     */
    public function getTitle()
    {
        if (Wfresource\Utility::getModuleOption('displaypagetitle')) {
            return $this->getVar('wfc_headline');
        }

        return '';
    }

    /**
     * Page::getContent()
     *
     * @param bool   $doPageNav
     * @param string $type
     * @return mixed
     */
    public function &getContent($doPageNav = true, $type = 'content')
    {
        $clean = new Wfresource\Clean(); //wfp_getClass('clean');

        $ret = $clean->getHtml($this->getVar('wfc_file'), $this->getVar('wfc_content', 'e'), $this->uploadDir);
        $this->setVar('wfc_content', htmlspecialchars_decode($ret));
        if ($doPageNav) {
            $text = \explode('[pagebreak]', $this->getVar('wfc_content', 'e'));
            if (\count($text) > 0) {
                require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

                $page = Request::getInt('page', 0); //Wfresource\Request::doRequest($_REQUEST, 'page', 0, 'int');
                $this->setVar('wfc_content', htmlspecialchars_decode($text[$page]));
                $pagenav = new \XoopsPageNav(\count($text), 1, $page, 'page', 'cid=' . $this->getVar('wfc_cid'));
                $this->setPageNav($pagenav);
            }
        }

        $contents = $this->getVar('wfc_content', 's');

        return $contents;
    }

    /**
     * Page::getBookMarks()
     *
     * @return mixed|string|void
     */
    public function getBookMarks()
    {
        if (Wfresource\Utility::getModuleOption('displaybookmarks')) {
            $addto = new Wfresource\AddTo(); //wfp_getClass('addto');

            return $addto->render($this->getTitle());
        }
    }

    /**
     * Page::getEmailLink()
     */
    public function getEmailLink(): string
    {
        return 'mailto:?subject='
               . \sprintf(\_MD_WFC_INTARTICLE, $GLOBALS['xoopsConfig']['sitename'])
               . '&amp;body='
               . \sprintf(\_MD_WFC_INTARTFOUND, $GLOBALS['xoopsConfig']['sitename'])
               . ':  '
               . XOOPS_URL
               . '/modules/'
               . $GLOBALS['xoopsModule']->getVar('dirname')
               . '/index.php?cid='
               . $this->getVar(
                'wfc_cid'
            );
    }

    /**
     * Page::getBookMarks()
     *
     * @return mixed
     */
    public function getPageNav()
    {
        return $this->pageNav->renderNav();
    }

    /**
     * Page::setPageNav()
     *
     * @param mixed $value
     */
    public function setPageNav($value): void
    {
        $this->pageNav = $value;
    }

    /**
     * Page::getMetaTitle()
     */
    public function getMetaKeyWords(): string
    {
        $desc = \explode(' ', \strip_tags($this->getVar('wfc_metakeywords')));
        $ret  = \implode(' ', \array_filter($desc, '\ltrim'));

        return $ret;
    }

    /**
     * Page::wfc_metatitle()
     */
    public function getMetaDescription(): string
    {
        return \strip_tags($this->getVar('wfc_metadescription'));
    }
}
