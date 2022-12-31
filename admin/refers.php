<?php declare(strict_types=1);

/**
 * Name: refers.php
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
use XoopsModules\Wfchannel;
use XoopsModules\Wfresource;

require_once __DIR__ . '/admin_header.php';

/**
 * Instance the call back
 */
$menuHandler->addHeader(_AM_WFC_REFERSAREA);
$refersHandler = new Wfchannel\RefersHandler($db); // wfp_getHandler('refers', _MODULE_DIR, _MODULE_CLASS);
$do_callback   = Wfresource\Utility::getObjectCallback($refersHandler);

/**
 * Switch
 */
$menu = 2;
$op   = Request::getString('op', 'default'); //Wfresource\Request::doRequest($_REQUEST, 'op', 'default', 'textbox');

xoops_cp_header();

switch ($op) {
    case 'delete':
        $do_callback->setMenu($menu);
        if (!Request::getInt('ok', 0)) {
            //Wfresource\Request::doRequest($_REQUEST, 'ok', 0, 'int')) {
            $menuHandler->addSubHeader(_AM_WFP_MAINAREA_DELETE_DSC);
        }
        if (!call_user_func([$do_callback, $op], null)) {
            $refersHandler->getHtmlErrors(true, $menu);
        }
        break;
    case 'deleteall':
        if (false === $do_callback->deleteall($op)) {
            $refersHandler->getHtmlErrors(true, $menu);
        }
        break;
    case 'default':
    default:
        $nav['start']  = Request::getInt('start', 0); //Wfresource\Request::doRequest($_REQUEST, 'start', 0, 'int');
        $nav['sort']   = Request::getInt('sort', 'wfcr_id'); //Wfresource\Request::doRequest($_REQUEST, 'sort', 'wfcr_id', 'int');
        $nav['order']  = Request::getString('order', 'ASC'); //Wfresource\Request::doRequest($_REQUEST, 'order', 'ASC', 'textbox');
        $nav['limit']  = Request::getInt('limit', 10); //Wfresource\Request::doRequest($_REQUEST, 'limit', 10, 'int');
        $nav['date']   = Request::getString('date', ''); //Wfresource\Request::doRequest($_REQUEST, 'date', '', 'textbox');
        $nav['search'] = Request::getString('search', ''); //Wfresource\Request::doRequest($_REQUEST, 'search', '', 'textbox');
        $nav['andor']  = Request::getString('andor', 'AND'); //Wfresource\Request::doRequest($_REQUEST, 'andor', 'AND', 'textbox');
        if (10 !== mb_strlen($nav['date'])) {
            $nav['date'] = strtotime($nav['date']);
        }
        foreach ($nav as $k => $v) {
            if (isset($_REQUEST[$k])) {
                $_SESSION['wfchannel']['refers'][$k] = $v;
            } else {
                if (isset($_SESSION['wfchannel']['refers'][$k])) {
                    $nav[$k] = $_SESSION['wfchannel']['refers'][$k];
                } else {
                    $_SESSION['wfchannel']['refers'][$k] = $v;
                }
            }
        }

        $tlist = new Wfresource\Tlist(); //wfp_getClass('tlist');
        $tlist->addFormStart('post', 'refers.php', 'refer');
        $tlist->addHeader('wfcr_id', '5', 'center', false);
        $tlist->addHeader('wfcr_uid', '20%', 'left', true);
        $tlist->addHeader('wfcr_date', '', 'center', true);
        $tlist->addHeader('wfcr_referurl', '', 'center', true);
        $tlist->addHeader('wfcr_ip', '', 'center', true);
        $tlist->addHeader('', '', 'center', 2);
        $tlist->addHeader('action', '', 'center', false);
        $tlist->addFooter(['deleteall' => _AM_WFC_DELETESELECTED]);
        $tlist->setPath('op=' . $op);

        $button = ['delete'];
        $_obj   = $refersHandler->getObj($nav, false);
        if ($_obj['count'] && count($_obj['list'])) {
            foreach ($_obj['list'] as $obj) {
                $wfcr_id = $obj->getVar('wfcr_id');
                $tlist->addHidden($wfcr_id, 'value_id');
                $tlist->add([
                                $wfcr_id,
                                $obj->getUserName('wfcr_uid'),
                                $obj->formatTimeStamp('wfcr_date'),
                                $obj->getReferUrl(),
                                $obj->getVar('wfcr_ip'),
                                $obj->getCheckbox('wfcr_id'),
                                Wfresource\Utility::getIcons($button, 'wfcr_id', $wfcr_id),
                            ]);
            }
        }
        // HTML output
        //        xoops_cp_header();

        /** @var Xmf\Module\Admin $adminObject */
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));

        //        $adminObject->displayIndex();

        $menuHandler->addSubHeader(_AM_WFC_REFERSAREA_DSC);
        $menuHandler->render($menu);
        $refersHandler->headingHtml($_obj['count']);
        $refersHandler->displayCalendar($nav, false);
        $tlist->render();
        Wfresource\Utility::showPagenav($_obj['count'], $nav['limit'], $nav['start'], 'start', 1, 'index.php?limit=' . $nav['limit']);
        Wfresource\Utility::showLegend($button);
        break;
}
//xoosla_cp_footer();
require_once __DIR__ . '/admin_footer.php';
