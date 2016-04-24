<?php
/**
 * Name: refers.php
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
include_once __DIR__ . '/admin_header.php';

/**
 * Instance the call back
 */
$menu_handler->addHeader(_AM_WFC_REFERSAREA);
$handler     = &wfp_getHandler('refers', _MODULE_DIR, _MODULE_CLASS);
$do_callback = &wfp_getObjectCallback($handler);

/**
 * Switch
 */
$menu = 2;
$op   = wfp_Request::doRequest($_REQUEST, 'op', 'default', 'textbox');
switch ($op) {
    case 'delete':
        $do_callback->setMenu($menu);
        if (!wfp_Request::doRequest($_REQUEST, 'ok', 0, 'int')) {
            $menu_handler->addSubHeader(_AM_WFP_MAINAREA_DELETE_DSC);
        }
        if (!call_user_func(array($do_callback, $op), null)) {
            $handler->getHtmlErrors(true, $menu);
        }
        break;

    case 'deleteall':
        if (false === $do_callback->deleteall($op)) {
            $handler->getHtmlErrors(true, $menu);
        }
        break;

    case 'default':
    default:
        $nav['start']  = wfp_Request::doRequest($_REQUEST, 'start', 0, 'int');
        $nav['sort']   = wfp_Request::doRequest($_REQUEST, 'sort', 'wfcr_id', 'int');
        $nav['order']  = wfp_Request::doRequest($_REQUEST, 'order', 'ASC', 'textbox');
        $nav['limit']  = wfp_Request::doRequest($_REQUEST, 'limit', 10, 'int');
        $nav['date']   = wfp_Request::doRequest($_REQUEST, 'date', '', 'textbox');
        $nav['search'] = wfp_Request::doRequest($_REQUEST, 'search', '', 'textbox');
        $nav['andor']  = wfp_Request::doRequest($_REQUEST, 'andor', 'AND', 'textbox');
        if (strlen($nav['date']) !== 10) {
            $nav['date'] = strtotime($nav['date']);
        }
        foreach ($nav as $k => $v) {
            if (isset($_REQUEST[$k])) {
                $_SESSION['wfchannel']['refers'][$k] = $nav[$k];
            } else {
                if (isset($_SESSION['wfchannel']['refers'][$k])) {
                    $nav[$k] = $_SESSION['wfchannel']['refers'][$k];
                } else {
                    $_SESSION['wfchannel']['refers'][$k] = $nav[$k];
                }
            }
        }

        $tlist = &wfp_getClass('tlist');
        $tlist->AddFormStart('post', 'refers.php', 'refer');
        $tlist->AddHeader('wfcr_id', '5', 'center', false);
        $tlist->AddHeader('wfcr_uid', '20%', 'left', true);
        $tlist->AddHeader('wfcr_date', '', 'center', true);
        $tlist->AddHeader('wfcr_referurl', '', 'center', true);
        $tlist->AddHeader('wfcr_ip', '', 'center', true);
        $tlist->AddHeader('', '', 'center', 2);
        $tlist->AddHeader('action', '', 'center', false);
        $tlist->addFooter(array('deleteall' => _AM_WFC_DELETESELECTED));
        $tlist->setPath('op=' . $op);

        $button = array('delete');
        $_obj   = $handler->getObj($nav, false);
        if ($_obj['count'] && count($_obj['list'])) {
            foreach ($_obj['list'] as $obj) {
                $wfcr_id = $obj->getVar('wfcr_id');
                $tlist->addHidden($wfcr_id, 'value_id');
                $tlist->add(array(
                                $wfcr_id,
                                $obj->getUserName('wfcr_uid'),
                                $obj->formatTimeStamp('wfcr_date'),
                                $obj->getReferUrl(),
                                $obj->getVar('wfcr_ip'),
                                $obj->getCheckbox('wfcr_id'),
                                wfp_getIcons($button, 'wfcr_id', $wfcr_id)
                            ));
            }
        }
        // HTML output
        xoops_cp_header();
        $menu_handler->addSubHeader(_AM_WFC_REFERSAREA_DSC);
        //        $menu_handler->render($menu);
        $handler->headingHtml($_obj['count']);
        $handler->displayCalendar($nav, false);
        $tlist->render();
        wfp_ShowPagenav($_obj['count'], $nav['limit'], $nav['start'], 'start', 1, 'index.php?limit=' . $nav['limit']);
        wfp_ShowLegend($button);
        break;
}
xoosla_cp_footer();
