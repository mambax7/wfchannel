<?php declare(strict_types=1);

/**
 * Name: permissions.php
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
use XoopsModules\Wfresource;

require_once __DIR__ . '/admin_header.php';

$op = Request::getString('op', 'default'); //Wfresource\Request::doRequest($_REQUEST, 'op', 'default', 'textbox');
switch ($op) {
    case 'default':
    default:
        xoops_cp_header();

        /** @var Xmf\Module\Admin $adminObject */
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));

        $menuHandler->addHeader(_AM_WFC_PERMISSIONAREA);
        $menuHandler->addSubHeader(_AM_WFC_REFERAREA_DSC);
        //        $menuHandler->render(4);

        ob_start('callback');
        $group = new Wfresource\Permissions(); //wfp_getClass('permissions');
        $group->setPermissions('wfcpages', 'page_read', '', $xoopsModule->getVar('mid'));
        $group->render(['cid' => 'wfc_cid', 'title' => 'wfc_title']);
        ob_end_flush();
        break;
}

//xoosla_cp_footer();
require_once __DIR__ . '/admin_footer.php';

/**
 * callback()
 *
 * @param mixed $buffer
 * @return mixed
 */
function callback($buffer)
{
    // replace all the apples with oranges
    return str_replace('<h4></h4>', '', $buffer);
}
