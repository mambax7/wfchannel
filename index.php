<?php declare(strict_types=1);

/**
 * Name: index.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use Xmf\Request;
use XoopsModules\Wfchannel\{
    Helper,
    PageHandler,
    LinkHandler,
    ReferHandler
};
use XoopsModules\Wfresource;

//$xoopsOption['template_main']   = 'wfchannel_index.tpl';

require_once __DIR__ . '/header.php';

//$op = Wfresource\Request::doRequest($_REQUEST, 'op', 'default', 'textbox');
$op = \Xmf\Request::getString('op', 'default');

$pageHandler = new PageHandler($db); //wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
switch ($op) {
    case 'refersend':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $url = Request::getString('HTTP_REFERER', '', 'SERVER') ?: $_SERVER['SCRIPT_NAME'];
            redirect_header($url, 1, $GLOBALS['xoopsSecurity']->getErrors(true));
        }
        $referHandler = new ReferHandler($db); //wfp_getHandler('refer', _MODULE_DIR, _MODULE_CLASS);

        $ret = false;

        xoops_load('XoopsCaptcha');
        $xoopsOption  = [];
        $xoopsCaptcha = XoopsCaptcha::getInstance();
        if (!$xoopsCaptcha->verify()) {
            $stop .= $xoopsCaptcha->getMessage();
        } else {
            $ret = $referHandler->refersend();
        }
        if (true !== $ret || !empty($ret)) {
            $GLOBALS['xoopsOption']['template_main'] = 'wfchannel_emailerror.tpl';
            require_once XOOPS_ROOT_PATH . '/header.php';
            $xoopsTpl->assign('wfc_email_error', $ret);
        } else {
            redirect_header(XOOPS_URL, 1, _MD_WFC_EMAILSENT);
        }
        break;
    case 'refer':
        if (!Wfresource\Utility::getModuleOption('act_refer')) {
            redirect_header(XOOPS_URL, 1, _MD_WFC_NORIGHTTOVIEWPAGE);
        }
        $referHandler = new ReferHandler($db); //wfp_getHandler('refer', _MODULE_DIR, _MODULE_CLASS);
        // test for banned IP address //
        $referHandler->doBanned();
        // show refer page //
        $refer_obj = $referHandler->get(1);
        if (!is_object($refer_obj)) {
            redirect_header(XOOPS_URL, 1, _MD_WFC_NORIGHTTOVIEWPAGE);
        }

        $GLOBALS['xoopsOption']['template_main'] = 'wfchannel_refer.tpl';
        require_once XOOPS_ROOT_PATH . '/header.php';
        $refer_obj->formEdit('referpage');
        $xoopsTpl->assign('refer', [
            'title'   => $refer_obj->getVar('wfcr_title'),
            'image'   => $refer_obj->getImage('wfcr_image', Wfresource\Utility::getModuleOption('uploaddir')),
            'content' => $refer_obj->getVar('wfcr_content'),
            'caption' => $refer_obj->getVar('wfcr_caption'),
        ]);
        unset($refer_obj);
        break;
    case 'link':
        if (!Wfresource\Utility::getModuleOption('act_link')) {
            redirect_header(XOOPS_URL, 1, _MD_WFC_NORIGHTTOVIEWPAGE);
        }
        $linkHandler = new LinkHandler($db); //wfp_getHandler('link', _MODULE_DIR, _MODULE_CLASS);
        $link_obj    = $linkHandler->get(1);
        if (!$link_obj) {
            redirect_header(XOOPS_URL, 1, _MD_WFC_NORIGHTTOVIEWPAGE);
        }

        $GLOBALS['xoopsOption']['template_main'] = 'wfchannel_linktous.tpl';
        require_once XOOPS_ROOT_PATH . '/header.php';
        $xoopsTpl->assign('linktous', [
            'textlink'    => $link_obj->getTextLink('wfcl_textlink'),
            'linkpath'    => Wfresource\Utility::getModuleOption('linkimages'),
            'image'       => $link_obj->getImage('wfcl_image', Wfresource\Utility::getModuleOption('uploaddir')),
            'logo'        => $link_obj->getImageUrl('wfcl_logo'),
            'button'      => $link_obj->getImageUrl('wfcl_button'),
            'banner'      => $link_obj->getImageUrl('wfcl_banner'),
            'microbutton' => $link_obj->getImageUrl('wfcl_microbutton'),
            'newsfeed'    => $link_obj->getVar('wfcl_newsfeed'),
            'newstitle'   => $link_obj->getVar('wfcl_newstitle'),
            'content'     => $link_obj->getVar('wfcl_content'),
            'title'       => $link_obj->getVar('wfcl_titlelink'),
            'caption'     => $link_obj->getVar('wfcl_caption'),
        ]);
        break;
    case 'page':
    default:
    Wfresource\Utility::loadLanguage('main', 'wfresource');
        $cid     = $pageHandler->getPageNumber();
        $pageObj = $pageHandler->get($cid, true, 'wfc_default');

        if (!is_object($pageObj)) {
            $pageObj = $pageHandler->create();
            $pageObj->setVar('wfc_headline', _MD_WFC_NOTITLESET);
            $pageObj->setVar('wfc_content', _MD_WFC_NOCONTENTSET);
            $pageObj->setVar('wfc_cid', 0);
            $pageObj->setVar('wfc_allowcomments', 0);
        } else {
            /**
             * Update counter
             */
            $pageHandler->update($pageObj);
        }

        $act = \Xmf\Request::getString('act', 'default'); //Wfresource\Request::doRequest($_REQUEST, 'act', 'default', 'textbox');
        switch ($act) {
            case 'print':
            case 'pdf':
            case 'rss':
                $pageHandler->getAction($pageObj, $act);
                break;
            case 'default':
            default:
                $xoopsOption['template_main']   = 'wfchannel_index.tpl';
                $xoopsOption['xoops_pagetitle'] = $pageObj->getVar('wfc_title');
                require_once XOOPS_ROOT_PATH . '/header.php';

                $helper = Helper::getInstance();
                if (1 == $helper->getConfig('xoopstags') && \class_exists(\XoopsModules\Tag\Tagbar::class) && \xoops_isActiveModule('tag')) {
                    $tagbarObj = new \XoopsModules\Tag\Tagbar();
                    $xoopsTpl->assign('tags', true);
                    $xoopsTpl->assign('tagbar', $tagbarObj->getTagbar($pageObj->getVar('wfc_cid'), 0));
                }

                $xoopsTpl->assign('page_info', [
                    'id'        => $pageObj->getVar('wfc_cid'),
                    'title'     => $pageObj->getTitle(),
                    'counter'   => sprintf(_MD_WFC_COUNTER, $pageObj->getVar('wfc_counter')),
                    'content'   => $pageObj->getContent(),
                    'published' => $pageObj->getTimestamp('wfc_publish'),
                    'author'    => $pageObj->getUserName('wfc_uid'),
                    'image'     => $pageObj->getImage('wfc_image', Wfresource\Utility::getModuleOption('uploaddir')),
                    'pagenav'   => $pageObj->getPageNav(),
                    'maillink'  => $pageObj->getEmailLink(),
                    'bookmarks' => $pageObj->getBookMarks(),
                    'caption'   => $pageObj->getVar('wfc_caption'),
                    'icons'     => $pageObj->getIcons(),
                ]);

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
                $xoopsTpl->assign('wfc_tag', Wfresource\Utility::module_installed('tag'));
                $xoopsTpl->assign($pageHandler->getRelated($pageObj));
                $xoopsTpl->assign('rsslink', Wfresource\Utility::getModuleOption('enablerss'));
                $xoopsTpl->assign('links', $pageHandler->getNextPreviousLinks($pageObj->getVar('wfc_cid')));
                /**
                 * Fix to allow comments on the main page without a cid
                 */
                $_GET['cid'] = $pageObj->getVar('wfc_cid');
                break;
        } // switch
}

$xoopsTpl->assign($pageHandler->getChanlinks());
$xoopsTpl->assign('copyright', sprintf(Wfresource\Utility::getModuleOption('copyrighttext'), date('Y'), $xoopsConfig['sitename']));
$xoopsTpl->assign('menu_top', in_array(Wfresource\Utility::getModuleOption('menulinks'), [1, 2], true));
$xoopsTpl->assign('menu_bottom', in_array(Wfresource\Utility::getModuleOption('menulinks'), [1, 3], true));
/**
 * Comments
 */
$xoopsTpl->assign('com_rule', 0);
if ((isset($pageObj) && ($pageObj->getVar('wfc_allowcomments') && Wfresource\Utility::getModuleOption('com_rule'))) ? 1 : 0) {
    $xoopsTpl->assign('com_rule', 1);
    $xoopsTpl->assign('wfc_comments', $pageObj->getVar('wfc_comments'));
    require XOOPS_ROOT_PATH . '/include/comment_view.php';
}
require_once __DIR__ . '/footer.php';
