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
 * @version    : $Id: index.php 8179 2011-11-07 00:54:10Z beckmi $
 */
include 'admin_header.php';

/**
 * Instance the call back
 */
$handler     = &wfp_gethandler('page', _MODULE_DIR, _MODULE_CLASS);
$do_callback = &wfp_getObjectCallback($handler);
$menu_handler->addHeader(_AM_WFCHANNEL_MAINAREA);

/**
 * Switch
 */
$op      = wfp_Request::doRequest($_REQUEST, 'op', 'default', 'textbox');
$options = null;
$do_callback->setMenu(0);
switch ($op) {
    case 'help':
    case 'about':
        if (!call_user_func(array($do_callback, $op), $options)) {
            $handler->getHtmlErrors(true, $menu);
        }
        break;

    case 'delete':
        if (!wfp_Request::doRequest($_REQUEST, 'ok', 0, 'int')) {
            $menu_handler->addSubHeader(_AM_WFP_MAINAREA_DELETE_DSC);
        }
        if (!call_user_func(array($do_callback, $op), $options)) {
            $handler->getHtmlErrors(true, $menu);
        }
        break;

    case 'view':
        $wfc_cid = wfp_Request::doRequest($_REQUEST, 'wfc_cid', 0, 'int');
        $URL     = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/index.php?cid=' . $wfc_cid;
        header("Location: $URL");
        break;

    case 'updateall':
        unset($_SESSION['wfc_channel']);
        $do_callback->updateall(array('wfc_headline', 'wfc_weight', 'wfc_mainmenu'));
        break;

    case 'duplicate':
        unset($_SESSION['wfc_channel']);
        $do_callback->setNotificationType('page_new');
        $do_callback->duplicate(array('wfc_default' => 0));
        break;

    case 'duplicateall':
        unset($_SESSION['wfc_channel']);
        $options = array('wfc_default' => 0);
        $do_callback->setNotificationType('page_new');
        if (false == $do_callback->duplicateall($options)) {
            $handler->getHtmlErrors(true, $menu);
        }
        break;

    case 'deleteall':
        unset($_SESSION['wfc_channel']);
        if (false == $do_callback->deleteall($op)) {
            $handler->getHtmlErrors(true, $menu);
        }
        break;

    case 'edit':
        $menu_handler->addSubHeader(_AM_WFCHANNEL_MAINAREA_EDIT_DSC);
        if (!call_user_func(array($do_callback, $op), $options)) {
            $handler->getHtmlErrors(true, $menu);
        }
        break;

    case 'save':
        unset($_SESSION['wfc_channel']);
        $do_callback->setBasics();
        $do_callback->setValueArray($_REQUEST);
        $do_callback->setValue('wfc_active', $_REQUEST['wfc_active']);
        $do_callback->setValueGroups('page_read', !empty($_REQUEST['page_read']) ? $_REQUEST['page_read'] : array(0 => '1'));
        $do_callback->setImage('wfc_image', $_REQUEST['wfc_image'], $_REQUEST['imgwidth'], $_REQUEST['imgheight']);

        /**
         */
        switch ($do_callback->getValue('wfc_active')) {
            case 0:
                $do_callback->setValueTime('wfc_publish', $_REQUEST['wfc_publish']);
                $do_callback->setValueTime('wfc_expired', $_REQUEST['wfc_expired']);
                break;
            case 1:
                // Published
                $time = (!empty($_REQUEST['wfc_publish'])) ? $_REQUEST['wfc_publish'] : time();
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
                $time = (!empty($_REQUEST['wfc_publish'])) ? $_REQUEST['wfc_publish'] : time();
                $do_callback->setValueTime('wfc_publish', $time);
                $do_callback->setValueTime('wfc_expired', time());
                break;
        }

        $ret = $do_callback->htmlImport($do_callback->getValue('wfc_file'), $do_callback->getValue('wfc_doimport'));
        if (isset($ret['content']) && !empty($ret['content'])) {
            $do_callback->setValue('wfc_content', $ret['content']);
            $do_callback->setValue('wfc_file', '');
        }

        if (isset($_REQUEST['wfc_usefiletitle']) && !empty($ret['title'])) {
            $do_callback->setValue('wfc_title', $ret['title']);
            $do_callback->setValue('wfc_headline', $ret['title']);
        }

        $ret = $do_callback->htmlClean($do_callback->getValue('wfc_content'), $_REQUEST['wfc_cleaningoptions'], $_REQUEST['wfc_usefiletitle']);
        if (null !== $ret) {
            $do_callback->setValue('wfc_content', $ret);
        }

        /**
         */
        if (wfp_Request::doRequest($_REQUEST, 'wfc_default', 0, 'int')) {
            $handler->updateDefaultPage(true);
            $do_callback->setValue('wfc_default', 1);
            if (empty($_REQUEST['wfc_publish'])) {
                $do_callback->setValueTime('wfc_publish', $date);
            }
        }

        /**
         * * code to remove pdf files created to update them *
         */
        $wfc_cid = wfp_Request::doRequest($_REQUEST, 'wfc_cid', 0, 'int');
        if ($wfc_cid > 0) {
            $pdf = wfp_getClass('dopdf');
            $pdf->deleteCache($wfc_cid, $_REQUEST['wfc_title']);
        }
        xoops_load('xoopscache');
        XoopsCache::delete('wfc_related' . md5($wfc_cid));
        /**
         */
        $do_callback->setNotificationType($wfc_cid > 0 ? 'page_modified' : 'page_new');
        if (!call_user_func(array($do_callback, $op), $options['noreturn'] = true)) {
            $handler->getHtmlErrors(false, $menu);
            exit();
        }
        break;

    case 'default':
    default:
        $nav['start']  = wfp_Request::doRequest($_REQUEST, 'start', 0, 'int');
        $nav['sort']   = wfp_Request::doRequest($_REQUEST, 'sort', 'wfc_cid', 'textbox');
        $nav['order']  = wfp_Request::doRequest($_REQUEST, 'order', 'DESC', 'textbox');
        $nav['limit']  = wfp_Request::doRequest($_REQUEST, 'limit', 10, 'int');
        $nav['date']   = wfp_Request::doRequest($_REQUEST, 'date', '', 'textbox');
        $nav['search'] = wfp_Request::doRequest($_REQUEST, 'search', '', 'textbox');
        $nav['active'] = wfp_Request::doRequest($_REQUEST, 'active', 0, 'int');
        $nav['andor']  = wfp_Request::doRequest($_REQUEST, 'andor', 'AND', 'textbox');
        if (strlen($nav['date']) != 10) {
            $nav['date'] = strtotime($nav['date']);
        }
        foreach ($nav as $k => $v) {
            if (isset($_REQUEST[$k])) {
                $_SESSION['wfchannel']['pages'][$k] = $nav[$k];
            } else {
                if (isset($_SESSION['wfchannel']['pages'][$k])) {
                    $nav[$k] = $_SESSION['wfchannel']['pages'][$k];
                } else {
                    $_SESSION['wfchannel']['pages'][$k] = $nav[$k];
                }
            }
        }

        $tlist = wfp_getClass('tlist');
        $tlist->AddFormStart('post', 'index.php', 'pages');
        $tlist->AddHeader('wfc_cid', '5', 'center', false);
        $tlist->AddHeader('wfc_title', '25%', 'left', true);
        $tlist->AddHeader('wfc_counter', '', 'center', true);
        $tlist->AddHeader('wfc_mainmenu', '', 'center', true);
        $tlist->AddHeader('wfc_publish', '', 'center', true);
        $tlist->AddHeader('wfc_expired', '', 'center', true);
        $tlist->AddHeader('wfc_weight', '', 'center', true);
        $tlist->AddHeader('', '', 'center', 2);
        $tlist->AddHeader('action', '', 'center', false);
        $tlist->addFooter();
        $button = array('../index.php' => 'view', 'edit', 'delete', 'duplicate');
        $_obj   = $handler->getObj($nav, true);
        if ($_obj['count'] && count($_obj['list'])) {
            foreach ($_obj['list'] as $obj) {
                $tlist->add(array(
                                $obj->getVar('wfc_cid'),
                                $obj->getTextbox('wfc_cid', 'wfc_title', '30'),
                                $obj->getVar('wfc_counter'),
                                $obj->getYesNobox('wfc_cid', 'wfc_mainmenu'),
                                $obj->formatTimeStamp('wfc_publish'),
                                $obj->formatTimeStamp('wfc_expired'),
                                $obj->getTextbox('wfc_cid', 'wfc_weight', '5'),
                                $obj->getCheckbox('wfc_cid'),
                                wfp_getIcons($button, 'wfc_cid', $obj->getVar('wfc_cid'))));
            }
        }
        // Html Output here
        xoops_cp_header();
        $menu_handler->addSubHeader(_AM_WFCHANNEL_MAINAREA_DSC);
//        $menu_handler->render(0);
        $handler->headingHtml($_obj['count']);
        $handler->displayCalendar($nav, true);
        $tlist->render();
        wfp_ShowPagenav($_obj['count'], $nav['limit'], $nav['start'], 'start', 1, 'limit=' . $nav['limit']);
        wfp_ShowLegend($button);
        break;
}
xoosla_cp_footer();
