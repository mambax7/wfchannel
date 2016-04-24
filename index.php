<?php
/**
 * Name: index.php
 * Description:
 *
 * @package    : Xoosla Modules
 * @Module     :
 * @subpackage :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */
include __DIR__ . '/header.php';

/**
 */
$op = wfp_Request::doRequest($_REQUEST, 'op', 'default', 'textbox');

/**
 */
$page_handler = &wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
switch ($op) {
    case 'refersend':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $url = $_SERVER['HTTP_REFERER'] ?: $_SERVER['PHP_SELF'];
            redirect_header($url, 1, $GLOBALS['xoopsSecurity']->getErrors(true));
        }
        $refer_handler = &wfp_getHandler('refer', _MODULE_DIR, _MODULE_CLASS);

        $ret = false;

        xoops_load('XoopsCaptcha');
        $xoopsOption = array();
        $xoopsCaptcha = XoopsCaptcha::getInstance();
        if (!$xoopsCaptcha->verify()) {
            $stop .= $xoopsCaptcha->getMessage();
        } else {
            $ret = $refer_handler->refersend();
        }
        if ($ret !== true || !empty($ret)) {
            $xoopsOption['template_main'] = 'wfchannel_emailerror.tpl';
            include XOOPS_ROOT_PATH . '/header.php';
            $xoopsTpl->assign('wfc_email_error', $ret);
        } else {
            redirect_header(XOOPS_URL, 1, _MD_WFC_EMAILSENT);
        }
        break;

    case 'refer':
        if (!wfp_getModuleOption('act_refer')) {
            redirect_header(XOOPS_URL, 1, _MD_WFC_NORIGHTTOVIEWPAGE);
        }
        $refer_handler = &wfp_getHandler('refer', _MODULE_DIR, _MODULE_CLASS);
        // test for banned IP address //
        $refer_handler->doBanned();
        // show refer page //
        $refer_obj = $refer_handler->get(1);
        if (!is_object($refer_obj)) {
            redirect_header(XOOPS_URL, 1, _MD_WFC_NORIGHTTOVIEWPAGE);
        }
        /**
         */
        $xoopsOption['template_main'] = 'wfchannel_refer.tpl';
        include_once XOOPS_ROOT_PATH . '/header.php';
        $refer_obj->formEdit('wfc_referpage');
        $xoopsTpl->assign('refer', array(
            'title'   => $refer_obj->getVar('wfcr_title'),
            'image'   => $refer_obj->getImage('wfcr_image', wfp_getModuleOption('uploaddir')),
            'content' => $refer_obj->getVar('wfcr_content'),
            'caption' => $refer_obj->getVar('wfcr_caption')
        ));
        unset($refer_obj);
        break;

    case 'link':
        if (!wfp_getModuleOption('act_link')) {
            redirect_header(XOOPS_URL, 1, _MD_WFC_NORIGHTTOVIEWPAGE);
        }
        $link_handler = &wfp_getHandler('link', _MODULE_DIR, _MODULE_CLASS);
        $link_obj     = $link_handler->get(1);
        if (!$link_obj) {
            redirect_header(XOOPS_URL, 1, _MD_WFC_NORIGHTTOVIEWPAGE);
        }

        $xoopsOption['template_main'] = 'wfchannel_linktous.tpl';
        include_once XOOPS_ROOT_PATH . '/header.php';
        $xoopsTpl->assign('linktous', array(
            'textlink'    => $link_obj->getTextLink('wfcl_textlink'),
            'linkpath'    => wfp_getModuleOption('linkimages'),
            'image'       => $link_obj->getImage('wfcl_image', wfp_getModuleOption('uploaddir')),
            'logo'        => $link_obj->getImageUrl('wfcl_logo'),
            'button'      => $link_obj->getImageUrl('wfcl_button'),
            'banner'      => $link_obj->getImageUrl('wfcl_banner'),
            'microbutton' => $link_obj->getImageUrl('wfcl_microbutton'),
            'newsfeed'    => $link_obj->getVar('wfcl_newsfeed'),
            'newstitle'   => $link_obj->getVar('wfcl_newstitle'),
            'content'     => $link_obj->getVar('wfcl_content'),
            'title'       => $link_obj->getVar('wfcl_titlelink'),
            'caption'     => $link_obj->getVar('wfcl_caption')
        ));
        break;

    case 'page':
    default:
        wfp_loadLangauge('main', 'wfresource');
        $cid     = $page_handler->getPageNumber();
        $pageObj = $page_handler->get($cid, true, 'wfc_default');

        if (!is_object($pageObj)) {
            $pageObj = $page_handler->create();
            $pageObj->setVar('wfc_headline', _MD_WFC_NOTITLESET);
            $pageObj->setVar('wfc_content', _MD_WFC_NOCONTENTSET);
            $pageObj->setVar('wfc_cid', 0);
            $pageObj->setVar('wfc_allowcomments', 0);
        } else {
            /**
             * Update counter
             */
            $page_handler->update($pageObj);
        }

        $act = wfp_Request::doRequest($_REQUEST, 'act', 'default', 'textbox');
        switch ($act) {
            case 'print':
            case 'pdf':
            case 'rss':
                $page_handler->getAction($pageObj, $act);
                break;

            case 'default':
            default:
                $xoopsOption['template_main']   = 'wfchannel_index.tpl';
                $xoopsOption['xoops_pagetitle'] = $pageObj->getVar('wfc_title');
                include_once(XOOPS_ROOT_PATH . '/header.php');
                /**
                 */
                if ($GLOBALS['xoopsModuleConfig']['xoopstags']) {
                    require_once XOOPS_ROOT_PATH . '/modules/tag/include/tagbar.php';
                    $xoopsTpl->assign('tags', true);
                    $xoopsTpl->assign('tagbar', tagBar($pageObj->getVar('wfc_cid'), 0));
                }
                $xoopsTpl->assign('page_info', array(
                    'id'        => $pageObj->getVar('wfc_cid'),
                    'title'     => $pageObj->getTitle(),
                    'counter'   => sprintf(_MD_WFC_COUNTER, $pageObj->getVar('wfc_counter')),
                    'content'   => $pageObj->getContent(),
                    'published' => $pageObj->getTimeStamp('wfc_publish'),
                    'author'    => $pageObj->getUserName('wfc_uid'),
                    'image'     => $pageObj->getImage('wfc_image', wfp_getModuleOption('uploaddir')),
                    'pagenav'   => $pageObj->getPageNav(),
                    'maillink'  => $pageObj->getEmailLink(),
                    'bookmarks' => $pageObj->getBookMarks(),
                    'caption'   => $pageObj->getVar('wfc_caption'),
                    'icons'     => $pageObj->getIcons()
                ));

                /**
                 * Hacked this in just now, will change later
                 */
                if (isset($xoTheme) && is_object($xoTheme)) {
                    $metaKeywords = $pageObj->getMetaKeyWords();
                    if ($metaKeywords) {
                        $xoTheme->addMeta('meta', 'keywords', $metaKeywords);
                    }
                    $metaDescription = $pageObj->getMetaDescription();
                    if ($metaDescription) {
                        $xoTheme->addMeta('meta', 'description', $metaDescription);
                    }
                }
                $xoopsTpl->assign('wfc_tag', wfp_module_installed('tag'));
                $xoopsTpl->assign($page_handler->getRelated($pageObj));
                $xoopsTpl->assign('rsslink', wfp_getModuleOption('enablerss'));
                $xoopsTpl->assign('links', $page_handler->getNextPreviousLinks($pageObj->getVar('wfc_cid')));
                /**
                 * Fix to allow comments on the main page without a cid
                 */
                $_GET['cid'] = $pageObj->getVar('wfc_cid');
                break;
        } // switch
}

/**
 */
$xoopsTpl->assign($page_handler->getChanlinks());
$xoopsTpl->assign('copyright', sprintf(wfp_getModuleOption('copyrighttext'), date('Y'), $xoopsConfig['sitename']));
$xoopsTpl->assign('menu_top', in_array(wfp_getModuleOption('menulinks'), array(1, 2)));
$xoopsTpl->assign('menu_bottom', in_array(wfp_getModuleOption('menulinks'), array(1, 3)));
/**
 * Comments
 */
$xoopsTpl->assign('com_rule', 0);
if ((isset($pageObj) && ($pageObj->getVar('wfc_allowcomments') && wfp_getModuleOption('com_rule'))) ? 1 : 0) {
    $xoopsTpl->assign('com_rule', 1);
    $xoopsTpl->assign('wfc_comments', $pageObj->getVar('wfc_comments'));
    include XOOPS_ROOT_PATH . '/include/comment_view.php';
}
include __DIR__ . '/footer.php';
