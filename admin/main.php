<?php declare(strict_types=1);

/**
 * Name: main.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Wfchannel\PageHandler;
use XoopsModules\Wfresource;
use XoopsModules\Wfresource\Tlist;


require_once __DIR__ . '/admin_header.php';

xoops_cp_header();

/**
 * Instance the call back
 */
$pageHandler = new PageHandler($db); //wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
$do_callback = Wfresource\Utility::getObjectCallback($pageHandler);
$menuHandler->addHeader(_AM_WFC_MAINAREA);

/**
 * Switch
 */
$op      = Request::getString('op', 'default'); //Wfresource\Request::doRequest($_REQUEST, 'op', 'default', 'textbox');
$options = null;
$do_callback->setMenu(0);
switch ($op) {
    case 'help':
    case 'about':
        if (!$do_callback->$op($options)) {
            $pageHandler->getHtmlErrors(true, $menu);
        }
        break;
    case 'delete':
        if (!Request::getInt('ok', 0)) { //Wfresource\Request::doRequest($_REQUEST, 'ok', 0, 'int')) {
            $menuHandler->addSubHeader(_AM_WFP_MAINAREA_DELETE_DSC);
        }
        //        if (!call_user_func(array($do_callback, $op), $options)) {
        if (!$do_callback->deleteById($options)) {
            $pageHandler->getHtmlErrors(true, $menu);
        }
        break;
    case 'view':
        $wfc_cid = Request::getInt('wfc_cid', 0); //Wfresource\Request::doRequest($_REQUEST, 'wfc_cid', 0, 'int');
        $URL     = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/index.php?cid=' . $wfc_cid;
        header("Location: $URL");
        break;
    case 'updateall':
        unset($_SESSION['wfc_channel']);
        $do_callback->updateall(['wfc_headline', 'wfc_weight', 'wfc_mainmenu']);
        break;
    case 'duplicate':
        unset($_SESSION['wfc_channel']);
        $do_callback->setNotificationType('page_new');
        $do_callback->duplicate(['wfc_default' => 0]);
        break;
    case 'duplicateall':
        unset($_SESSION['wfc_channel']);
        $options = ['wfc_default' => 0];
        $do_callback->setNotificationType('page_new');
        if (false === $do_callback->duplicateall($options)) {
            $pageHandler->getHtmlErrors(true, $menu);
        }
        break;
    case 'deleteall':
        unset($_SESSION['wfc_channel']);
        if (false === $do_callback->deleteall($op)) {
            $pageHandler->getHtmlErrors(true, $menu);
        }
        break;
    case 'edit':
        $menuHandler->addSubHeader(_AM_WFC_MAINAREA_EDIT_DSC);
        if (!$do_callback->$op($options)) {
            $pageHandler->getHtmlErrors(true, $menu);
        }
        break;
    case 'save':
        unset($_SESSION['wfc_channel']);
        $do_callback->setBasics();
        $do_callback->setValueArray($_REQUEST);
        $do_callback->setValue('wfc_active', $_REQUEST['wfc_active']);
        $do_callback->setValueGroups('page_read', !empty($_REQUEST['page_read']) ? $_REQUEST['page_read'] : [0 => '1']);
        $do_callback->setImage('wfc_image', $_REQUEST['wfc_image']??'', $_REQUEST['imgwidth'], $_REQUEST['imgheight']);

        switch ($do_callback->getValue('wfc_active')) {
            case 0:
                $do_callback->setValueTime('wfc_publish', $_REQUEST['wfc_publish']);
                $do_callback->setValueTime('wfc_expired', $_REQUEST['wfc_expired']);
                break;
            case 1:
                // Published
                $time = !empty($_REQUEST['wfc_publish']) ? $_REQUEST['wfc_publish'] : time();
                $do_callback->setValueTime('wfc_publish', $time);
                $do_callback->setValueTime('wfc_expired', '');
                break;
            case 2:
                // unpublished
                $do_callback->setValueTime('wfc_publish', '');
                $do_callback->setValueTime('wfc_expired', '');
                break;
            case 3:
                // expired
                $time = !empty($_REQUEST['wfc_publish']) ? $_REQUEST['wfc_publish'] : time();
                $do_callback->setValueTime('wfc_publish', $time);
                $do_callback->setValueTime('wfc_expired', time());
                break;
        }

        $ret = $do_callback->htmlImport($do_callback->getValue('wfc_file'), $do_callback->getValue('wfc_doimport'));
        if (isset($ret['content']) && !empty($ret['content'])) {
            $do_callback->setValue('wfc_content', $ret['content']);
            $do_callback->setValue('wfc_file', '');
        }

        if (Request::hasVar('wfc_usefiletitle', 'REQUEST') && !empty($ret['title'])) {
            $do_callback->setValue('wfc_title', $ret['title']);
            $do_callback->setValue('wfc_headline', $ret['title']);
        }

        $ret = $do_callback->htmlClean($do_callback->getValue('wfc_content'), $_REQUEST['wfc_cleaningoptions'], $_REQUEST['wfc_usefiletitle']);
        if (null !== $ret) {
            $do_callback->setValue('wfc_content', $ret);
        }

        if (Request::getInt('wfc_default', 0)) { //Wfresource\Request::doRequest($_REQUEST, 'wfc_default', 0, 'int')) {
            $pageHandler->updateDefaultPage(true);
            $do_callback->setValue('wfc_default', 1);
            if (empty($_REQUEST['wfc_publish'])) {
                $do_callback->setValueTime('wfc_publish', $date);
            }
        }

        /**
         * * code to remove pdf files created to update them *
         */
        $wfc_cid = Request::getInt('wfc_cid', 0); //Wfresource\Request::doRequest($_REQUEST, 'wfc_cid', 0, 'int');
        if ($wfc_cid > 0) {
            $pdf = new Wfresource\Pdf(); //wfp_getClass('dopdf');
            $pdf->deleteCache($wfc_cid, $_REQUEST['wfc_title']);
        }
        xoops_load('xoopscache');
        \XoopsCache::delete('wfc_related' . md5((string)$wfc_cid));

        $do_callback->setNotificationType($wfc_cid > 0 ? 'page_modified' : 'page_new');
        if (!$do_callback->$op($options['noreturn'] = true)) {
            $pageHandler->getHtmlErrors(false, $menu);
            exit();
        }
        break;
    case 'default':
    default:
        $nav           = [];
        $nav['start']  = Request::getInt('start', 0); //Wfresource\Request::doRequest($_REQUEST, 'start', 0, 'int');
        $nav['sort']   = Request::getString('sort', 'wfc_cid'); //Wfresource\Request::doRequest($_REQUEST, 'sort', 'wfc_cid', 'textbox');
        $nav['order']  = Request::getString('order', 'DESC'); //Wfresource\Request::doRequest($_REQUEST, 'order', 'DESC', 'textbox');
        $nav['limit']  = Request::getInt('limit', 0); //Wfresource\Request::doRequest($_REQUEST, 'limit', 10, 'int');
        $nav['date']   = Request::getString('date', ''); //Wfresource\Request::doRequest($_REQUEST, 'date', '', 'textbox');
        $nav['search'] = Request::getString('search', ''); //Wfresource\Request::doRequest($_REQUEST, 'search', '', 'textbox');
        $nav['active'] = Request::getInt('active', 0); //Wfresource\Request::doRequest($_REQUEST, 'active', 0, 'int');
        $nav['andor']  = Request::getString('andor', 'AND'); //Wfresource\Request::doRequest($_REQUEST, 'andor', 'AND', 'textbox');
        if (10 !== mb_strlen($nav['date'])) {
            $nav['date'] = strtotime($nav['date']);
        }
        foreach ($nav as $k => $v) {
            if (isset($_REQUEST[$k])) {
                $_SESSION['wfchannel']['pages'][$k] = $v;
            } elseif (isset($_SESSION['wfchannel']['pages'][$k])) {
                $nav[$k] = $_SESSION['wfchannel']['pages'][$k];
            } else {
                $_SESSION['wfchannel']['pages'][$k] = $v;
            }
        }

        //        $tlist = wfp_getClass('Tlist');
        $tlist = new Tlist();
        $tlist->addFormStart('post', 'main.php', 'pages');
        $tlist->addHeader('wfc_cid', '5', 'center', false);
        $tlist->addHeader('wfc_title', '25%', 'left', true);
        $tlist->addHeader('wfc_counter', '', 'center', true);
        $tlist->addHeader('wfc_mainmenu', '', 'center', true);
        $tlist->addHeader('wfc_publish', '', 'center', true);
        $tlist->addHeader('wfc_expired', '', 'center', true);
        $tlist->addHeader('wfc_weight', '', 'center', true);
        $tlist->addHeader('', '', 'center', 2);
        $tlist->addHeader('action', '', 'center', false);
        $tlist->addFooter();
        $button = ['../main.php' => 'view', 'edit', 'delete', 'duplicate'];
        $_obj   = $pageHandler->getObj($nav, true);
        if ($_obj['count'] && count($_obj['list'])) {
            foreach ($_obj['list'] as $obj) {
                $tlist->add([
                                $obj->getVar('wfc_cid'),
                                $obj->getTextbox('wfc_cid', 'wfc_title', '30'),
                                $obj->getVar('wfc_counter'),
                                $obj->getYesNobox('wfc_cid', 'wfc_mainmenu'),
                                $obj->formatTimeStamp('wfc_publish'),
                                $obj->formatTimeStamp('wfc_expired'),
                                $obj->getTextbox('wfc_cid', 'wfc_weight', '5'),
                                $obj->getCheckbox('wfc_cid'),
                                Wfresource\Utility::getIcons($button, 'wfc_cid', $obj->getVar('wfc_cid')),
                            ]);
            }
        }
        // Html Output here
        //        xoops_cp_header();

        /** @var Xmf\Module\Admin $adminObject */
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));

        $menuHandler->addSubHeader(_AM_WFC_MAINAREA_DSC);
        //                $menuHandler->render(0);
        $pageHandler->headingHtml($_obj['count']);
        $pageHandler->displayCalendar($nav, true);
        $tlist->render();
        Wfresource\Utility::showPagenav($_obj['count'], $nav['limit'], $nav['start'], 'start', 1, 'limit=' . $nav['limit']);
        Wfresource\Utility::showLegend($button);
        break;
}
//xoosla_cp_footer();
require_once __DIR__ . '/admin_footer.php';
