<?php
/**
 * Name: permissions.php
 * Description:
 *
 * @package    : Xoosla Modules
 * @Module     :
 * @subpackage :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 * @version    : $Id: permissions.php 8179 2011-11-07 00:54:10Z beckmi $
 */
include 'admin_header.php';

$op = wfp_Request::doRequest($_REQUEST, 'op', 'default', 'textbox');
switch ($op) {
    case 'default':
    default:
        xoops_cp_header();
        $menu_handler->addHeader(_AM_WFCHANNEL_PERMISSIONAREA);
        $menu_handler->addSubHeader(_AM_WFCHANNEL_REFERAREA_DSC);
//        $menu_handler->render(4);

        ob_start('callback');
        $group = wfp_getClass('permissions');
        $group->setPermissions('wfcpages', 'page_read', '', $xoopsModule->getVar('mid'));
        $group->render(array('cid' => 'wfc_cid', 'title' => 'wfc_title'));
        ob_end_flush();
        break;
}
xoosla_cp_footer();

/**
 * callback()
 *
 * @param mixed $buffer
 * @return mixed
 */
function callback($buffer)
{
    // replace all the apples with oranges
    return (str_replace("<h4></h4>", "", $buffer));
}
