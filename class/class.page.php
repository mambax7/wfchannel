<?php
/**
 * Name: class.page.php
 * Description:
 *
 * @package    : Xoosla Modules
 * @Module     : WF-Channel
 * @subpackage :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use Xmf\Request;

defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

/**
 * Include resource classes
 */
wfp_getObjectHandler();

/**
 * wfc_Page
 *
 * @package
 * @author    John
 * @copyright Copyright (c) 2009
 * @access    public
 */
class wfc_Page extends wfp_Object
{
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
        $this->initVar('wfc_cid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfc_title', XOBJ_DTYPE_TXTBOX, null, true, 120);
        $this->initVar('wfc_headline', XOBJ_DTYPE_TXTBOX, null, false, 150);
        $this->initVar('wfc_content', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('wfc_weight', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_default', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_image', XOBJ_DTYPE_TXTBOX, '||', false, 250);
        $this->initVar('wfc_file', XOBJ_DTYPE_TXTBOX, '', false, 250);
        $this->initVar('wfc_usefiletitle', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_created', XOBJ_DTYPE_INT, time(), false);
        $this->initVar('wfc_publish', XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfc_expired', XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfc_mainmenu', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('wfc_submenu', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('wfc_counter', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_comments', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_allowcomments', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('wfc_uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfc_metakeywords', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('wfc_metadescription', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('wfc_related', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('wfc_author', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('wfc_caption', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('wfc_active', XOBJ_DTYPE_INT, 1, false);
        // **//
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('doxcode', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('dosmiley', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('doimage', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('dobr', XOBJ_DTYPE_INT, 1, false);

        $this->uploadDir = $GLOBALS['xoopsModuleConfig']['htmluploaddir'];
    }

    /**
     * wfc_Page::getIcons()
     * @return array
     */
    public function getIcons()
    {
        $iconArray = wfp_getModuleOption('pageicon');
        $flipped   = array_flip($iconArray);

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
     * wfc_Page::getUserName()
     *
     * @param  mixed  $value
     * @param  string $timestamp
     * @param  mixed  $usereal
     * @param  mixed  $linked
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
     * wfc_Page::getTitle()
     * @return mixed|string
     */
    public function getTitle()
    {
        if (wfp_getModuleOption('displaypagetitle')) {
            return $this->getVar('wfc_headline');
        } else {
            return '';
        }
    }

    /**
     * wfc_Page::getContent()
     *
     * @param  bool   $doPageNav
     * @param  string $type
     * @return mixed
     */
    public function &getContent($doPageNav = true, $type = 'content')
    {
        $clean = wfp_getClass('clean');

        $ret = $clean->getHtml($this->getVar('wfc_file'), $this->getVar('wfc_content', 'e'), $this->uploadDir);
        $this->setVar('wfc_content', htmlspecialchars_decode($ret));
        if (true === $doPageNav) {
            $text = explode('[pagebreak]', $this->getVar('wfc_content', 'e'));
            if (count($text) > 0) {
                require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

                $page = wfp_Request::doRequest($_REQUEST, 'page', 0, 'int');
                $this->setVar('wfc_content', htmlspecialchars_decode($text[$page]));
                $pagenav = new XoopsPageNav(count($text), 1, $page, 'page', 'cid=' . $this->getVar('wfc_cid'));
                $this->setPageNav($pagenav);
            }
        }

        $contents = $this->getVar('wfc_content', 's');

        return $contents;
    }

    /**
     * wfc_Page::getBookMarks()
     *
     * @return
     */
    public function getBookMarks()
    {
        if (wfp_getModuleOption('displaybookmarks')) {
            $addto = wfp_getClass('addto');

            return $addto->render($this->getTitle());
        }
    }

    /**
     * wfc_Page::getEmailLink()
     * @return string
     */
    public function getEmailLink()
    {
        return 'mailto:?subject='
               . sprintf(_MD_WFC_INTARTICLE, $GLOBALS['xoopsConfig']['sitename'])
               . '&amp;body='
               . sprintf(_MD_WFC_INTARTFOUND, $GLOBALS['xoopsConfig']['sitename'])
               . ':  '
               . XOOPS_URL
               . '/modules/'
               . $GLOBALS['xoopsModule']->getVar('dirname')
               . '/index.php?cid='
               . $this->getVar('wfc_cid');
    }

    /**
     * wfc_Page::getBookMarks()
     *
     * @return
     */
    public function getPageNav()
    {
        return $this->pageNav->renderNav();
    }

    /**
     * wfc_Page::setPageNav()
     *
     * @param mixed $value
     */
    public function setPageNav($value)
    {
        $this->pageNav = $value;
    }

    /**
     * wfc_Page::getMetaTitle()
     * @return string
     */
    public function getMetaKeyWords()
    {
        $desc = explode(' ', strip_tags($this->getVar('wfc_metakeywords')));
        $ret  = implode(' ', array_filter($desc, 'ltrim'));

        return $ret;
    }

    /**
     * wfc_Page::wfc_metatitle()
     * @return string
     */
    public function getMetaDescription()
    {
        return strip_tags($this->getVar('wfc_metadescription'));
    }
}

/**
 * wfc_PageHandler
 *
 * @package
 * @author    John
 * @copyright Copyright (c) 2007
 * @access    public
 */
class wfc_PageHandler extends wfp_ObjectHandler
{
    public $usestags = true;

    /**
     * wfc_PageHandler::XoopsCategoryHandler()
     *
     * @param mixed $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'wfcpages', 'wfc_Page', 'wfc_cid', 'wfc_title', 'page_read');
    }

    /**
     * wfc_PageHandler::getList()
     *
     * @param  string $sort
     * @param  string $order
     * @param  int    $start
     * @param  int    $limit
     * @return array|bool
     */
    public function &getList($sort = 'wfc_weight', $order = 'ASC', $start = 0, $limit = 0)
    {
        static $channels;

        if (!$channels) {
            $criteriaPublished = new CriteriaCompo();
            $criteriaPublished->add(new Criteria('wfc_publish', 0, '>'));
            $criteriaPublished->add(new Criteria('wfc_publish', time(), '<='));

            $criteriaExpired = new CriteriaCompo();
            $criteriaExpired->add(new Criteria('wfc_expired', 0, '='));
            $criteriaExpired->add(new Criteria('wfc_expired', time(), '>'), 'OR');

            $criteria = new CriteriaCompo();
            $criteria->add($criteriaPublished);
            $criteria->add($criteriaExpired);
            $criteria->add(new Criteria('wfc_mainmenu', 1, '='), 'AND');
            $criteria->add(new Criteria('wfc_default', 0, '='));

            $criteria->setSort('wfc_weight');
            $criteria->setOrder('ASC');
            $criteria->setStart($start);
            $criteria->setLimit($start);
            $channels = $this->getObjects($criteria);
        }

        return $channels;
    }

    /**
     * wfc_PageHandler::getDefaultPage()
     * @return string
     */
    public function &getDefaultPage()
    {
        $ret = '';
        $obj = $this->get(0, true, 'wfc_default');
        if (is_object($obj)) {
            $ret['id']    = $_SESSION['wfchanneldefault']['id'] = $obj->getVar('wfc_cid');
            $ret['title'] = $_SESSION['wfchanneldefault']['title'] = $obj->getVar('wfc_title');
        }

        return $ret;
    }

    /**
     * wfc_PageHandler::getObj()
     * @return array|bool
     */
    public function &getObj()
    {
        $myts = MyTextSanitizer::getInstance();

        $obj = [];
        if (2 === func_num_args()) {
            $args     = func_get_args();
            $criteria = new CriteriaCompo();
            if (!empty($args[0]['search'])) {
                $args[0]['search'] = stripslashes($args[0]['search']);
                if (isset($args[0]['andor']) && 'exact' !== $args[0]['andor']) {
                    $temp_queries = preg_split('/[\s,]+/', $args[0]['search']);
                    $queryarray   = [];
                    foreach ($temp_queries as $q) {
                        $q = trim($q);
                        if (strlen($q) >= 5) {
                            $queryarray[] = $GLOBALS['xoopsDB']->escape($q);
                        }
                    }
                } else {
                    $queryarray = [trim($GLOBALS['xoopsDB']->escape($args[0]['search']))];
                }
                $criteriaSearch = $this->searchCriteria($queryarray, $args[0]['andor'], true, $criteria);
            }
            if (!empty($args[0]['date'])) {
                $addon_date = $this->getaDate($args[0]['date']);
                if ($addon_date['begin'] && $addon_date['end']) {
                    $criteriaDate = new CriteriaCompo();
                    $criteriaDate->add(new Criteria('wfc_publish', wfp_addslashes($addon_date['begin']), '>='));
                    $criteriaDate->add(new Criteria('wfc_publish', wfp_addslashes($addon_date['end']), '<='));
                    $criteria->add($criteriaDate);
                }
            }
            switch ((int)$args[0]['active']) {
                case 1:
                    // $criteria->add( new Criteria( 'wfc_publish', 1, '=' ) );
                    $criteriaPublished = new CriteriaCompo();
                    $criteriaPublished->add(new Criteria('wfc_publish', 0, '>'));
                    $criteriaPublished->add(new Criteria('wfc_publish', time(), '<='));
                    $criteria->add($criteriaPublished);
                    break;
                case 2:
                    $criteria->add(new Criteria('wfc_publish', 0, '='));
                    break;
                case 3:
                    $criteriaExpired = new CriteriaCompo();
                    $criteriaExpired->add(new Criteria('wfc_expired', time(), '>'), 'OR');
                    $criteria->add($criteriaExpired);
                    break;
                case 4:
                    $criteria->add(new Criteria('wfc_active', (int)$args[0]['active'], '='));
                    break;
            }
            $obj['count'] = $this->getCount($criteria);
            if (!empty($args[0])) {
                $criteria->setSort(wfp_addslashes($args[0]['sort']));
                $criteria->setOrder(wfp_addslashes($args[0]['order']));
                $criteria->setStart((int)$args[0]['start']);
                $criteria->setLimit((int)$args[0]['limit']);
            }
            $obj['list'] = $this->getObjects($criteria, $args[1]);
        }

        return $obj;
    }

    /**
     * wfc_PageHandler::getRelated()
     *
     * @param $obj
     * @return array|mixed
     */
    public function &getRelated(&$obj)
    {
        xoops_load('xoopscache');
        $ret = XoopsCache::read('wfc_related' . md5($obj->getVar('wfc_cid')));
        if (!$ret) {
            $relatedTerms = explode(' ', $obj->getVar('wfc_related'));
            $relatedTerms = array_filter(array_map('trim', $relatedTerms));
            $page_search  =& $this->getSearch($relatedTerms, $andor = '', 10, 0, false);
            $ret          = [];
            $i            = 0;
            if (!empty($page_search['list'])) {
                foreach ($page_search['list'] as $object) {
                    if ($object->getVar('wfc_cid') === $obj->getVar('wfc_cid')) {
                        continue;
                    }
                    $ret['related'][$i] = [
                        'link'  => $object->getVar('wfc_cid'),
                        'title' => $object->getTitle(),
                        'time'  => $object->getTimeStamp('wfc_publish'),
                        'uid'   => $object->getVar('wfc_author') ?: $object->getUserName('wfc_uid')
                    ];
                    ++$i;
                }
            }
            XoopsCache::write('wfc_related' . md5($obj->getVar('wfc_cid')), $ret);
        }

        return $ret;
    }

    /**
     * wfc_PageHandler::getNextPreviousLinks()
     *
     * @param $cid
     * @return mixed
     */
    public function getNextPreviousLinks($cid)
    {
        if (!wfp_getModuleOption('allow_pnlinks')) {
            return false;
        }

        $page = wfp_Request::doRequest($_REQUEST, 'page', 0, 'int');

        $wfpages_obj = $this->getList();
        $array_keys  = [];
        foreach ($wfpages_obj as $key => $obj) {
            $array_keys[$key] = $obj->getVar('wfc_cid');
        }
        $current_item = array_search($cid, $array_keys);

        $previous          = $current_item - 1;
        $links['previous'] = '';
        if ($previous >= 0) {
            if (is_object($wfpages_obj[$previous])) {
                $links['previous']['link']  = 'index.php?cid=' . $wfpages_obj[$previous]->getVar('wfc_cid');
                $links['previous']['title'] = $wfpages_obj[$previous]->getVar('wfc_title');
            }
        }
        // }
        $next          = $current_item + 1;
        $links['next'] = '';
        if ($next < count($array_keys)) {
            if (is_object($wfpages_obj[$next])) {
                $links['next']['link']  = 'index.php?cid=' . $wfpages_obj[$next]->getVar('wfc_cid');
                $links['next']['title'] = $wfpages_obj[$next]->getVar('wfc_title');
            }
        }

        return $links;
    }

    /**
     * wfc_PageHandler::getChanlinks()
     * @return mixed
     */
    public function &getChanlinks()
    {
        $cid = wfp_Request::doRequest($_REQUEST, 'cid', 0, 'int');
        $op  = wfp_Request::doRequest($_REQUEST, 'op', '', 'textbox');

        $css = (0 === $cid && !$op) ? 'page_underline' : 'page_none';

        $wfpages['chanlink'][] = ['css' => $css, 'id' => '', 'title' => _MD_WFC_HOME];
        $wfpages_obj           =& $this->getList();

        if (!empty($wfpages_obj)) {
            foreach (array_keys($wfpages_obj) as $i) {
                $css                   = ($wfpages_obj[$i]->getVar('wfc_cid') === $cid) ? 'page_underline' : 'page_none';
                $wfpages['chanlink'][] = [
                    'css'   => $css,
                    'id'    => '?cid=' . $wfpages_obj[$i]->getVar('wfc_cid'),
                    'title' => $wfpages_obj[$i]->getVar('wfc_title')
                ];
            }
            unset($wfpages_obj);
        }
        /**
         * Links
         */

        if (!wfp_getModuleOption('act_link')) {
            unset($_SESSION['wfc_channel']['wfcl_titlelink']);
        }

        $css = ('link' === $op) ? 'page_underline' : 'page_none';
        if (!isset($_SESSION['wfc_channel']['wfcl_titlelink'])) {
            $linksHandler = wfp_getHandler('link', _MODULE_DIR, _MODULE_CLASS);
            $links        = $linksHandler->get(1);
            if ($links && wfp_getModuleOption('act_link')) {
                $_SESSION['wfc_channel']['wfcl_titlelink'] = $links->getVar('wfcl_titlelink');
                if (is_object($links) && $links->getVar('wfcl_mainpage')) {
                    $wfpages['chanlink'][] = [
                        'css'   => $css,
                        'id'    => '?op=link',
                        'title' => $links->getVar('wfcl_titlelink')
                    ];
                }
            }
        } else {
            if (isset($_SESSION['wfc_channel']['wfcl_titlelink'])) {
                $wfpages['chanlink'][] = [
                    'css'   => $css,
                    'id'    => '?op=link',
                    'title' => $_SESSION['wfc_channel']['wfcl_titlelink']
                ];
            }
        }

        /**
         * Refer
         */
        if (!$GLOBALS['xoopsModuleConfig']['act_refer']) {
            unset($_SESSION['wfc_channel']['wfcr_title']);
        }
        $css = ('refer' === $op) ? 'page_underline' : 'page_none';
        if (!isset($_SESSION['wfc_channel']['wfcr_title'])) {
            $referHandler = wfp_getHandler('refer', _MODULE_DIR, _MODULE_CLASS);
            $refer        = $referHandler->get(1);
            if ($refer && $GLOBALS['xoopsModuleConfig']['act_refer']) {
                $_SESSION['wfc_channel']['wfcr_title'] = $refer->getVar('wfcr_title');
                if (is_object($refer) && $refer->getVar('wfcr_mainpage')) {
                    $wfpages['chanlink'][] = [
                        'css'   => $css,
                        'id'    => '?op=refer',
                        'title' => $refer->getVar('wfcr_title')
                    ];
                }
            }
        } else {
            if (isset($_SESSION['wfc_channel']['wfcr_title'])) {
                $wfpages['chanlink'][] = [
                    'css'   => $css,
                    'id'    => '?op=refer',
                    'title' => $_SESSION['wfc_channel']['wfcr_title']
                ];
            }
        }

        return $wfpages;
    }

    /**
     * wfc_PageHandler::update()
     *
     * @param $obj
     * @return bool
     */
    public function update(&$obj)
    {
        if ((is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin())
            && (isset($GLOBALS['xoopsModuleConfig']['allow_admin'])
                && 0 === $GLOBALS['xoopsModuleConfig']['allow_admin'])) {
            return false;
        } else {
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('wfc_cid', $obj->getVar('wfc_cid')));
            $this->updateCounter('wfc_counter', $criteria);
        }
    }

    /**
     * wfc_PageHandler::updateDefaultPage()
     *
     * @param bool $doFull
     */
    public function updateDefaultPage($doFull = false)
    {
        if ($doFull) {
            $this->updateAll('wfc_default', 0);
        }
        unset($_SESSION['wfchanneldefault']);
    }

    /**
     * wfc_PageHandler::searchCriteria()
     *
     * @param mixed  $queryarray
     * @param string $andor
     * @param mixed  $moreChecks
     * @param        $criteria
     */
    public function searchCriteria($queryarray, $andor = '', $moreChecks, &$criteria)
    {
        $criteriaSearch = new CriteriaCompo();

        if (isset($queryarray[0])) {
            if (true === $moreChecks) {
                $criteriaSearch->add(new Criteria('wfc_title', "%$queryarray[0]%", 'LIKE'), 'OR');
                $criteriaSearch->add(new Criteria('wfc_headline', "%$queryarray[0]%", 'LIKE'), 'OR');
                $criteriaSearch->add(new Criteria('wfc_content', "%$queryarray[0]%", 'LIKE'), 'OR');
            }
            $criteriaSearch->add(new Criteria('wfc_related', "%$queryarray[0]%", 'LIKE'), 'OR');
        }
        if (!empty($andor)) {
            for ($i = 1, $iMax = count($queryarray); $i < $iMax; ++$i) {
                if (true === $moreChecks) {
                    $criteriaSearch->add(new Criteria('wfc_title', "%$queryarray[$i]%", 'LIKE'), 'OR');
                    $criteriaSearch->add(new Criteria('wfc_headline', "%$queryarray[$i]%", 'LIKE'), 'OR');
                    $criteriaSearch->add(new Criteria('wfc_content', "%$queryarray[$i]%", 'LIKE'), 'OR');
                }
                $criteriaSearch->add(new Criteria('wfc_related', "%$queryarray[$i]%", 'LIKE'), 'OR');
            }
        }
        $criteria->add($criteriaSearch);
    }

    /**
     * wfc_PageHandler::getSearch()
     *
     * @param  mixed $queryarray
     * @param  mixed $andor
     * @param  mixed $limit
     * @param  mixed $offset
     * @param  bool  $moreChecks
     * @return mixed
     */
    public function &getSearch($queryarray, $andor, $limit, $offset, $moreChecks = true)
    {
        //        if ($andor !== 'exact') {
        //            $andor = $andor;
        //        } else {
        //            $andor = '';
        //        }
        if ('exact' === $andor) {
            $andor = '';
        }

        $criteria = new CriteriaCompo();
        if (is_array($queryarray) && count($queryarray)) {
            $this->searchCriteria($queryarray, $andor, $moreChecks, $criteria);
            $criteriaPublished = new CriteriaCompo();
            $criteriaPublished->add(new Criteria('wfc_publish', 0, '>'));
            $criteriaPublished->add(new Criteria('wfc_publish', time(), '<='));
            $criteria->add($criteriaPublished);

            $criteriaExpired = new CriteriaCompo();
            $criteriaExpired->add(new Criteria('wfc_expired', 0, '='));
            $criteriaExpired->add(new Criteria('wfc_expired', time(), '>'), 'OR');
            $criteria->add($criteriaExpired);

            $criteria->add(new Criteria('wfc_active', 4, '!='));

            $criteria->setSort('wfc_publish');
            $criteria->setOrder('DESC');
            $criteria->setStart((int)$offset);
            $criteria->setLimit((int)$limit);
            $obj['list'] = $this->getObjects($criteria, false);
        }

        return $obj;
    }

    /**
     * wfc_PageHandler::getAction()
     *
     * @param mixed $obj
     * @param mixed $act
     */
    public function getAction(&$obj, $act)
    {
        /**
         * do switch
         */
        switch ($act) {
            case 'print':
                $printerPage = wfp_getClass('doprint', _RESOURCE_DIR, _RESOURCE_CLASS);
                $printerPage->setOptions($this->pdf_data($obj, $act));
                $printerPage->doRender();
                break;
            case 'rss':
                if (file_exists($file = XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/include/rss.php')) {
                    include $file;
                } else {
                    $file = str_replace(XOOPS_ROOT_PATH, '', $file);
                    error_reporting(sprintf(_MD_WFC_FILENOTFOUND, $file, __FILE__, __LINE__));
                }
                break;
            case 'pdf':
                $pdfPage = wfp_getClass('dopdf', _RESOURCE_DIR, _RESOURCE_CLASS);
                $ret     = $pdfPage->getCache($obj->getVar('wfc_cid'), $obj->getVar('wfc_cid'));
                if (!$ret) {
                    $pdfPage->setOptions($this->pdf_data($obj, $act));
                    $pdfPage->doRender();
                }
                break;
        } // switch
        exit();
    }

    /**
     * wfc_PageHandler::pdf_data()
     *
     * @param  mixed $obj
     * @param        $act
     * @return mixed
     */
    public function pdf_data(&$obj, $act)
    {
        $pdf_data['id']          = $obj->getVar('wfc_cid');
        $pdf_data['title']       = $obj->getVar('wfc_title');
        $pdf_data['subtitle']    = $obj->getVar('wfc_headline');
        $pdf_data['creator']     = $GLOBALS['xoopsConfig']['sitename'];
        $pdf_data['subsubtitle'] = '';
        $pdf_data['renderdate']  = $obj->formatTimeStamp('today');
        $pdf_data['pdate']       = $obj->formatTimeStamp('wfc_publish');
        $pdf_data['slogan']      = $GLOBALS['xoopsConfig']['sitename'] . ' - ' . $GLOBALS['xoopsConfig']['slogan'];
        $pdf_data['content']     = $obj->getVar('wfc_content');
        $pdf_data['sitename']    = $GLOBALS['xoopsConfig']['sitename'];
        $pdf_data['itemurl']     = XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/index.php?index.php?cid=' . $obj->getVar('wfc_cid');
        $pdf_data['stdoutput']   = 'file';

        return $pdf_data;
    }

    /**
     * wfc_PageHandler::getPageNumber()
     * @return int
     */
    public function getPageNumber()
    {
        $ret = 0;
        if (isset($_REQUEST['wfc_cid'])) {
            $ret = $ok = wfp_Request::doRequest($_REQUEST, 'wfc_cid', 0, 'int');
        } elseif (isset($_REQUEST['cid'])) {
            $ret = wfp_Request::doRequest($_REQUEST, 'cid', 0, 'int');
        } elseif (isset($_REQUEST['pagenum'])) {
            $ret = wfp_Request::doRequest($_REQUEST, 'pagenum', 0, 'int');
        }

        return (int)$ret;
    }

    /**
     * wfc_PageHandler::upDateNotification()
     *
     * @param        $obj
     * @param string $page_type
     */
    public function upDateNotification(&$obj, $page_type = '')
    {
        $tags = [];
        switch ($page_type) {
            case 'page_modified':
                $tags['PAGE_NAME']   = $obj->getVar('wfc_title');
                $tags['PAGE_URL']    = XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/index.php?cid=' . $obj->getVar('wfc_cid');
                $notificationHandler = xoops_getHandler('notification');
                $notificationHandler->triggerEvent('page', $obj->getVar('wfc_cid'), $page_type, $tags);
                break;
            case 'page_new':
            default:
                $tags['PAGE_NAME']   = $obj->getVar('wfc_title');
                $tags['PAGE_URL']    = XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/index.php?cid=' . $obj->getVar('wfc_cid');
                $notificationHandler = xoops_getHandler('notification');
                $notificationHandler->triggerEvent('page', $obj->getVar('wfc_cid'), $page_type, $tags);
                break;
        }
    }

    /**
     * wfc_PageHandler::upTagHandler()
     *
     * @param mixed $obj
     * @internal param string $page_type
     */
    public function upTagHandler($obj)
    {
        $item_tag   = wfp_Request::doRequest($_REQUEST, 'item_tag', '', 'textbox');
        $tagHandler = xoops_getModuleHandler('tag', 'tag');
        if ($tagHandler) {
            $tagHandler->updateByItem($item_tag, $obj->getVar('wfc_cid'), $GLOBALS['xoopsModule']->getVar('dirname'), 0);
        }
    }

    /**
     * wfc_PageHandler::pageInfo()
     *
     * @param $obj
     * @return string
     * @internal param mixed $itemid
     */
    public function pageInfo(&$obj)
    {
        $url = XOOPS_URL . '/modules/system/admin.php?module=' . $GLOBALS['xoopsModule']->getVar('mid') . '&status=0&limit=10&fct=comments&selsubmit=Go%21';
        $ret = '<div>' . _AM_WFC_TOTALCOMENTS . '<b>' . $obj->getVar('wfc_comments') . '</b>';
        if ($obj->getVar('wfc_comments')) {
            $ret .= '&nbsp;<a href="' . $url . '">' . _AM_WFC_VIEWCOMMENTS . '</a>';
        }

        $ret  .= '</div>';
        $ret  .= '<div>' . _AM_WFC_TOTALPAGEREADS . '<b>' . $obj->getVar('wfc_counter') . '</b></div>';
        $ret  .= '<div>' . _AM_WFC_PAGECREATED . '<b>' . formatTimestamp($obj->getVar('wfc_created')) . '</b></div>';
        $time = $obj->getVar('wfc_publish') ? formatTimestamp($obj->getVar('wfc_publish')) : '';
        $ret  .= '<div>' . _AM_WFC_LASUPDATED . '<b>' . $time . '</b></div><br>';

        return $ret;
    }

    /**
     * wfc_RefersHandler::displayCalendar()
     * @return string
     */
    public function headingHtml()
    {
        $ret = '';
        if (1 !== func_num_args()) {
            return $ret;
        }
        $total_count   = $this->getCount();
        $refersHandler = wfp_getHandler('refers', 'wfchannel', 'wfc_');
        $refer_count   = $refersHandler->getEmailSentCount();
        $default       = $this->getDefaultPage();
        $ret           .= '<input class="wfbutton" type="button" name="button" onclick=\'location="main.php?op=edit"\' value="' . _AM_WFP_CREATENEW . '">';
        $ret           .= '<div style="padding-bottom: 8px;">';
        if (null === $default) {
            $ret .= _AM_WFC_NODEFAULTPAGESET;
        } else {
            $ret .= _AM_WFC_DEFAULTPAGESET . ": <a href='../main.php?op=edit&wfc_cid=" . $default['id'] . "'>" . $default['title'] . '</a>';
        }
        $ret .= '<div>' . _AM_WFC_TOTALNUMCHANL . ': <b>' . $total_count . '</b></div>';
        $ret .= '<div>' . _AM_WFC_TOTALEMAILSSENT . ': <b>' . $refer_count . '</b></div>';
        if ($refer_count > 0) {
            $ret .= '<a href="' . XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/admin/refers.php">' . _AM_WFP_VIEW . '</a><br>';
        }
        $ret .= '</div>';
        echo $ret;
        unset($referHandler);
    }
}
