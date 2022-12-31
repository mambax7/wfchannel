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

/**
 * PageHandler
 *
 * @author    John
 * @copyright Copyright (c) 2007
 */
class PageHandler extends Wfresource\WfpObjectHandler
{
    public $usestags = true;

    /**
     * PageHandler::XoopsCategoryHandler()
     *
     * @param mixed $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wfcpages', Page::class, 'wfc_cid', 'wfc_title', 'page_read');
    }

    /**
     * PageHandler::getList()
     *
     * @param string $sort
     * @param string $order
     * @param int    $start
     * @param int    $limit
     * @return array|bool
     */
    public function &getList($sort = 'wfc_weight', $order = 'ASC', $start = 0, $limit = 0)
    {
        static $channels;

        if (!$channels) {
            $criteriaPublished = new \CriteriaCompo();
            $criteriaPublished->add(new \Criteria('wfc_publish', 0, '>'));
            $criteriaPublished->add(new \Criteria('wfc_publish', \time(), '<='));

            $criteriaExpired = new \CriteriaCompo();
            $criteriaExpired->add(new \Criteria('wfc_expired', 0, '='));
            $criteriaExpired->add(new \Criteria('wfc_expired', \time(), '>'), 'OR');

            $criteria = new \CriteriaCompo();
            $criteria->add($criteriaPublished);
            $criteria->add($criteriaExpired);
            $criteria->add(new \Criteria('wfc_mainmenu', 1, '='), 'AND');
            $criteria->add(new \Criteria('wfc_default', 0, '='));

            $criteria->setSort('wfc_weight');
            $criteria->setOrder('ASC');
            $criteria->setStart($start);
            $criteria->setLimit($start);
            $channels = $this->getObjects($criteria);
        }

        return $channels;
    }

    /**
     * PageHandler::getDefaultPage()
     * @return array|string
     */
    public function &getDefaultPage()
    {
        $ret = '';
        $obj = $this->get(0, true, 'wfc_default');
        if (\is_object($obj)) {
            $ret          = [];
            $ret['id']    = $_SESSION['wfchanneldefault']['id'] = $obj->getVar('wfc_cid');
            $ret['title'] = $_SESSION['wfchanneldefault']['title'] = $obj->getVar('wfc_title');
        }

        return $ret;
    }

    /**
     * PageHandler::getObj()
     * @return array
     */
    public function getObj(...$args)
    {
        $myts = \MyTextSanitizer::getInstance();

        $obj = [];
        if (2 === \func_num_args()) {
//            $args     = \func_get_args();
            $criteria = new \CriteriaCompo();
            if (!empty($args[0]['search'])) {
                $args[0]['search'] = \stripslashes($args[0]['search']);
                if (isset($args[0]['andor']) && 'exact' !== $args[0]['andor']) {
                    $temp_queries = \preg_split('/[\s,]+/', $args[0]['search']);
                    $queryarray   = [];
                    foreach ($temp_queries as $q) {
                        $q = \trim($q);
                        if (mb_strlen($q) >= 5) {
                            $queryarray[] = $GLOBALS['xoopsDB']->escape($q);
                        }
                    }
                } else {
                    $queryarray = [\trim($GLOBALS['xoopsDB']->escape($args[0]['search']))];
                }
                $criteriaSearch = $this->searchCriteria($queryarray, $args[0]['andor'], true, $criteria);
            }
            if (!empty($args[0]['date'])) {
                $addon_date = $this->getaDate($args[0]['date']);
                if ($addon_date['begin'] && $addon_date['end']) {
                    $criteriaDate = new \CriteriaCompo();
                    $criteriaDate->add(new \Criteria('wfc_publish', Wfresource\Utility::addslashes($addon_date['begin']), '>='));
                    $criteriaDate->add(new \Criteria('wfc_publish', Wfresource\Utility::addslashes($addon_date['end']), '<='));
                    $criteria->add($criteriaDate);
                }
            }
            switch ((int)$args[0]['active']) {
                case 1:
                    // $criteria->add( new \Criteria( 'wfc_publish', 1, '=' ) );
                    $criteriaPublished = new \CriteriaCompo();
                    $criteriaPublished->add(new \Criteria('wfc_publish', 0, '>'));
                    $criteriaPublished->add(new \Criteria('wfc_publish', \time(), '<='));
                    $criteria->add($criteriaPublished);
                    break;
                case 2:
                    $criteria->add(new \Criteria('wfc_publish', 0, '='));
                    break;
                case 3:
                    $criteriaExpired = new \CriteriaCompo();
                    $criteriaExpired->add(new \Criteria('wfc_expired', \time(), '>'), 'OR');
                    $criteria->add($criteriaExpired);
                    break;
                case 4:
                    $criteria->add(new \Criteria('wfc_active', (int)$args[0]['active'], '='));
                    break;
            }
            $obj['count'] = $this->getCount($criteria);
            if (!empty($args[0])) {
                $criteria->setSort(Wfresource\Utility::addslashes($args[0]['sort']));
                $criteria->setOrder(Wfresource\Utility::addslashes($args[0]['order']));
                $criteria->setStart((int)$args[0]['start']);
                $criteria->setLimit((int)$args[0]['limit']);
            }
            $obj['list'] = $this->getObjects($criteria, $args[1]);
        }

        return $obj;
    }

    /**
     * PageHandler::getRelated()
     *
     * @param $obj
     * @return array|mixed
     */
    public function &getRelated($obj)
    {
        \xoops_load('xoopscache');
        $ret = \XoopsCache::read('wfc_related' . \md5((string)$obj->getVar('wfc_cid')));
        if (!$ret) {
            $relatedTerms = \explode(' ', $obj->getVar('wfc_related'));
            $relatedTerms = \array_filter(\array_map('\trim', $relatedTerms));
            $page_search  = &$this->getSearch($relatedTerms, $andor = '', 10, 0, false);
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
                        'time'  => $object->getTimestamp('wfc_publish'),
                        'uid'   => $object->getVar('wfc_author') ?: $object->getUserName('wfc_uid'),
                    ];
                    ++$i;
                }
            }
            \XoopsCache::write('wfc_related' . \md5((string)$obj->getVar('wfc_cid')), $ret);
        }

        return $ret;
    }

    /**
     * PageHandler::getNextPreviousLinks()
     *
     * @param $cid
     * @return array|false
     */
    public function getNextPreviousLinks($cid)
    {
        if (!Wfresource\Utility::getModuleOption('allow_pnlinks')) {
            return false;
        }

        $page = Request::getInt('page', 0); //Wfresource\Request::doRequest($_REQUEST, 'page', 0, 'int');

        $wfpages_obj = $this->getList();
        $array_keys  = [];
        foreach ($wfpages_obj as $key => $obj) {
            $array_keys[$key] = $obj->getVar('wfc_cid');
        }
        $current_item = \array_search($cid, $array_keys, true);

        $previous          = $current_item - 1;
        $links = [];
        $links['previous'] = [];
        if ($previous >= 0) {
            if (\is_object($wfpages_obj[$previous])) {
                $links['previous']['link']  = 'index.php?cid=' . $wfpages_obj[$previous]->getVar('wfc_cid');
                $links['previous']['title'] = $wfpages_obj[$previous]->getVar('wfc_title');
            }
        }
        // }
        $next          = $current_item + 1;
        $links['next'] = [];
        if ($next < \count($array_keys)) {
            if (\is_object($wfpages_obj[$next])) {
                $links['next']['link']  = 'index.php?cid=' . $wfpages_obj[$next]->getVar('wfc_cid');
                $links['next']['title'] = $wfpages_obj[$next]->getVar('wfc_title');
            }
        }

        return $links;
    }

    /**
     * PageHandler::getChanlinks()
     * @return array
     */
    public function &getChanlinks()
    {
        $helper = Helper::getInstance();
        $cid    = Request::getInt('cid', 0); //Wfresource\Request::doRequest($_REQUEST, 'cid', 0, 'int');
        $op     = Request::getString('op', ''); //Wfresource\Request::doRequest($_REQUEST, 'op', '', 'textbox');

        $css = (0 === $cid && !$op) ? 'page_underline' : 'page_none';

        $wfpages['chanlink'][] = ['css' => $css, 'id' => '', 'title' => \_MD_WFC_HOME];
        $wfpages_obj           = &$this->getList();

        if (!empty($wfpages_obj)) {
            foreach (\array_keys($wfpages_obj) as $i) {
                $css                   = ($wfpages_obj[$i]->getVar('wfc_cid') === $cid) ? 'page_underline' : 'page_none';
                $wfpages['chanlink'][] = [
                    'css'   => $css,
                    'id'    => '?cid=' . $wfpages_obj[$i]->getVar('wfc_cid'),
                    'title' => $wfpages_obj[$i]->getVar('wfc_title'),
                ];
            }
            unset($wfpages_obj);
        }
        /**
         * Links
         */
        if (!Wfresource\Utility::getModuleOption('act_link')) {
            unset($_SESSION['wfc_channel']['wfcl_titlelink']);
        }

        $css = ('link' === $op) ? 'page_underline' : 'page_none';
        if (!isset($_SESSION['wfc_channel']['wfcl_titlelink'])) {
            $linksHandler = $helper->getHandler('Link'); //wfp_getHandler('link', _MODULE_DIR, _MODULE_CLASS);
            $links        = $linksHandler->get(1);
            if ($links && Wfresource\Utility::getModuleOption('act_link')) {
                $_SESSION['wfc_channel']['wfcl_titlelink'] = $links->getVar('wfcl_titlelink');
                if (\is_object($links) && $links->getVar('wfcl_mainpage')) {
                    $wfpages['chanlink'][] = [
                        'css'   => $css,
                        'id'    => '?op=link',
                        'title' => $links->getVar('wfcl_titlelink'),
                    ];
                }
            }
        } else {
            if (isset($_SESSION['wfc_channel']['wfcl_titlelink'])) {
                $wfpages['chanlink'][] = [
                    'css'   => $css,
                    'id'    => '?op=link',
                    'title' => $_SESSION['wfc_channel']['wfcl_titlelink'],
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
            $referHandler = $helper->getHandler('Refer'); //wfp_getHandler('refer', _MODULE_DIR, _MODULE_CLASS);
            $refer        = $referHandler->get(1);
            if ($refer && $GLOBALS['xoopsModuleConfig']['act_refer']) {
                $_SESSION['wfc_channel']['wfcr_title'] = $refer->getVar('wfcr_title');
                if (\is_object($refer) && $refer->getVar('wfcr_mainpage')) {
                    $wfpages['chanlink'][] = [
                        'css'   => $css,
                        'id'    => '?op=refer',
                        'title' => $refer->getVar('wfcr_title'),
                    ];
                }
            }
        } else {
            if (isset($_SESSION['wfc_channel']['wfcr_title'])) {
                $wfpages['chanlink'][] = [
                    'css'   => $css,
                    'id'    => '?op=refer',
                    'title' => $_SESSION['wfc_channel']['wfcr_title'],
                ];
            }
        }

        return $wfpages;
    }

    /**
     * PageHandler::update()
     *
     * @param $obj
     * @return bool|void
     */
    public function update($obj)
    {
        if ((\is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin())
            && (isset($GLOBALS['xoopsModuleConfig']['allow_admin'])
                && 0 === $GLOBALS['xoopsModuleConfig']['allow_admin'])) {
            return false;
        }
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('wfc_cid', $obj->getVar('wfc_cid')));
        $this->updateCounter('wfc_counter', $criteria);
    }

    /**
     * PageHandler::updateDefaultPage()
     *
     * @param bool $doFull
     */
    public function updateDefaultPage($doFull = false): void
    {
        if ($doFull) {
            $this->updateAll('wfc_default', 0);
        }
        unset($_SESSION['wfchanneldefault']);
    }

    /**
     * PageHandler::searchCriteria('')
     *
     * @param mixed  $queryarray
     * @param string $andor
     * @param mixed  $moreChecks
     * @param        $criteria
     */
    public function searchCriteria($queryarray, $andor, $moreChecks, $criteria): void
    {
        $criteriaSearch = new \CriteriaCompo();

        if (isset($queryarray[0])) {
            if (true === $moreChecks) {
                $criteriaSearch->add(new \Criteria('wfc_title', "%$queryarray[0]%", 'LIKE'), 'OR');
                $criteriaSearch->add(new \Criteria('wfc_headline', "%$queryarray[0]%", 'LIKE'), 'OR');
                $criteriaSearch->add(new \Criteria('wfc_content', "%$queryarray[0]%", 'LIKE'), 'OR');
            }
            $criteriaSearch->add(new \Criteria('wfc_related', "%$queryarray[0]%", 'LIKE'), 'OR');
        }
        if (!empty($andor)) {
            for ($i = 1, $iMax = \count($queryarray); $i < $iMax; ++$i) {
                if (true === $moreChecks) {
                    $criteriaSearch->add(new \Criteria('wfc_title', "%$queryarray[$i]%", 'LIKE'), 'OR');
                    $criteriaSearch->add(new \Criteria('wfc_headline', "%$queryarray[$i]%", 'LIKE'), 'OR');
                    $criteriaSearch->add(new \Criteria('wfc_content', "%$queryarray[$i]%", 'LIKE'), 'OR');
                }
                $criteriaSearch->add(new \Criteria('wfc_related', "%$queryarray[$i]%", 'LIKE'), 'OR');
            }
        }
        $criteria->add($criteriaSearch);
    }

    /**
     * PageHandler::getSearch()
     *
     * @param mixed $queryarray
     * @param mixed $andor
     * @param mixed $limit
     * @param mixed $offset
     * @param bool  $moreChecks
     * @return array
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

        $criteria = new \CriteriaCompo();
        if (\is_array($queryarray) && \count($queryarray)) {
            $this->searchCriteria($queryarray, $andor, $moreChecks, $criteria);
            $criteriaPublished = new \CriteriaCompo();
            $criteriaPublished->add(new \Criteria('wfc_publish', 0, '>'));
            $criteriaPublished->add(new \Criteria('wfc_publish', \time(), '<='));
            $criteria->add($criteriaPublished);

            $criteriaExpired = new \CriteriaCompo();
            $criteriaExpired->add(new \Criteria('wfc_expired', 0, '='));
            $criteriaExpired->add(new \Criteria('wfc_expired', \time(), '>'), 'OR');
            $criteria->add($criteriaExpired);

            $criteria->add(new \Criteria('wfc_active', 4, '!='));

            $criteria->setSort('wfc_publish');
            $criteria->setOrder('DESC');
            $criteria->setStart((int)$offset);
            $criteria->setLimit((int)$limit);
            $obj['list'] = $this->getObjects($criteria, false);
        }

        return $obj;
    }

    /**
     * PageHandler::getAction()
     *
     * @param mixed $obj
     * @param mixed $act
     */
    public function getAction($obj, $act): void
    {
        /**
         * do switch
         */
        switch ($act) {
            case 'print':
                $printerPage = new Wfresource\Printer(); //wfp_getClass('doprint', _RESOURCE_DIR, _RESOURCE_CLASS);
                $printerPage->setOptions($this->pdf_data($obj, $act));
                $printerPage->doRender();
                break;
            case 'rss':
                if (\is_file($file = XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/include/rss.php')) {
                    require_once $file;
                } else {
                    $file = \str_replace(XOOPS_ROOT_PATH, '', $file);
                    \error_reporting(\sprintf(\_MD_WFC_FILENOTFOUND, $file, __FILE__, __LINE__));
                }
                break;
            case 'pdf':
                $pdfPage = new Wfresource\Pdf(); //wfp_getClass('dopdf', _RESOURCE_DIR, _RESOURCE_CLASS);
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
     * PageHandler::pdf_data()
     *
     * @param mixed  $obj
     * @param        $act
     * @return array
     */
    public function pdf_data($obj, $act)
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
     * PageHandler::getPageNumber()
     */
    public function getPageNumber(): int
    {
        $ret = 0;
        if (Request::hasVar('wfc_cid', 'REQUEST')) {
            $ret = $ok = Request::getInt('wfc_cid', 0); //Wfresource\Request::doRequest($_REQUEST, 'wfc_cid', 0, 'int');
        } elseif (Request::hasVar('cid', 'REQUEST')) {
            $ret = Request::getInt('cid', 0); //Wfresource\Request::doRequest($_REQUEST, 'cid', 0, 'int');
        } elseif (Request::hasVar('pagenum', 'REQUEST')) {
            $ret = Request::getInt('pagenum', 0); //Wfresource\Request::doRequest($_REQUEST, 'pagenum', 0, 'int');
        }

        return (int)$ret;
    }

    /**
     * PageHandler::upDateNotification()
     *
     * @param        $obj
     * @param string $page_type
     */
    public function upDateNotification($obj, $page_type = ''): void
    {
        $tags = [];
        switch ($page_type) {
            case 'page_modified':
                $tags['PAGE_NAME'] = $obj->getVar('wfc_title');
                $tags['PAGE_URL']  = XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/index.php?cid=' . $obj->getVar('wfc_cid');
                /** @var \XoopsNotificationHandler $notificationHandler */
                $notificationHandler = \xoops_getHandler('notification');
                $notificationHandler->triggerEvent('page', $obj->getVar('wfc_cid'), $page_type, $tags);
                break;
            case 'page_new':
            default:
                $tags['PAGE_NAME']   = $obj->getVar('wfc_title');
                $tags['PAGE_URL']    = XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/index.php?cid=' . $obj->getVar('wfc_cid');
                $notificationHandler = \xoops_getHandler('notification');
                $notificationHandler->triggerEvent('page', $obj->getVar('wfc_cid'), $page_type, $tags);
                break;
        }
    }

    /**
     * PageHandler::upTagHandler()
     *
     * @param mixed $obj
     * @internal param string $page_type
     */
    public function upTagHandler($obj): void
    {
        $item_tag   = Request::getString('item_tag', ''); //Wfresource\Request::doRequest($_REQUEST, 'item_tag', '', 'textbox');
        $tagHandler = \XoopsModules\Tag\Helper::getInstance()->getHandler('Tag');
        if ($tagHandler) {
            $tagHandler->updateByItem($item_tag, $obj->getVar('wfc_cid'), $GLOBALS['xoopsModule']->getVar('dirname'), 0);
        }
    }

    /**
     * PageHandler::pageInfo()
     *
     * @param $obj
     * @internal param mixed $itemid
     */
    public function pageInfo($obj): string
    {
        $url = XOOPS_URL . '/modules/system/admin.php?module=' . $GLOBALS['xoopsModule']->getVar('mid') . '&status=0&limit=10&fct=comments&selsubmit=Go%21';
        $ret = '<div>' . \_AM_WFC_TOTALCOMENTS . '<b>' . $obj->getVar('wfc_comments') . '</b>';
        if ($obj->getVar('wfc_comments')) {
            $ret .= '&nbsp;<a href="' . $url . '">' . \_AM_WFC_VIEWCOMMENTS . '</a>';
        }

        $ret  .= '</div>';
        $ret  .= '<div>' . \_AM_WFC_TOTALPAGEREADS . '<b>' . $obj->getVar('wfc_counter') . '</b></div>';
        $ret  .= '<div>' . \_AM_WFC_PAGECREATED . '<b>' . \formatTimestamp($obj->getVar('wfc_created')) . '</b></div>';
        $time = $obj->getVar('wfc_publish') ? \formatTimestamp($obj->getVar('wfc_publish')) : '';
        $ret  .= '<div>' . \_AM_WFC_LASUPDATED . '<b>' . $time . '</b></div><br>';

        return $ret;
    }

    /**
     * RefersHandler::displayCalendar()
     */
    public function headingHtml(...$args)
    {
        $ret = '';
        if (1 !== \func_num_args()) {
            return $ret;
        }
        $db            = \XoopsDatabaseFactory::getDatabaseConnection();
        $total_count   = $this->getCount();
        $refersHandler = new RefersHandler($db); //wfp_getHandler('refers', 'wfchannel', 'wfc_');
        $refer_count   = $refersHandler->getEmailSentCount();
        $default       = $this->getDefaultPage();
        $ret           .= '<input class="wfbutton" type="button" name="button" onclick=\'location="main.php?op=edit"\' value="' . \_AM_WFP_CREATENEW . '">';
        $ret           .= '<div style="padding-bottom: 8px;">';
        if ('' === $default) {
            $ret .= \_AM_WFC_NODEFAULTPAGESET;
        } else {
            $ret .= \_AM_WFC_DEFAULTPAGESET . ": <a href='../main.php?op=edit&wfc_cid=" . $default['id'] . "'>" . $default['title'] . '</a>';
        }
        $ret .= '<div>' . \_AM_WFC_TOTALNUMCHANL . ': <b>' . $total_count . '</b></div>';
        $ret .= '<div>' . \_AM_WFC_TOTALEMAILSSENT . ': <b>' . $refer_count . '</b></div>';
        if ($refer_count > 0) {
            $ret .= '<a href="' . XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/admin/refers.php">' . \_AM_WFP_VIEW . '</a><br>';
        }
        $ret .= '</div>';
        echo $ret;
        unset($referHandler);
    }
}
