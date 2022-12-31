<?php declare(strict_types=1);

/**
 * Name: refer.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use Xmf\Request;
use XoopsModules\Wfchannel;
use XoopsModules\Wfresource;

require_once __DIR__ . '/admin_header.php';

$menuHandler->addHeader(_AM_WFC_REFERAREA);
$referHandler = new Wfchannel\ReferHandler($db); //wfp_getHandler('refer', _MODULE_DIR, _MODULE_CLASS);
$do_callback  = Wfresource\Utility::getObjectCallback($referHandler);

xoops_cp_header();

$op = Request::getString('op', 'edit'); //Wfresource\Request::doRequest($_REQUEST, 'op', 'edit', 'textbox');
switch ($op) {
    case 'edit':
    default:
        $menu = 1;
        $menuHandler->addSubHeader(_AM_WFC_REFERAREA_DSC);
        $do_callback->setId(1);
        $do_callback->setMenu($menu);
        if (!$do_callback->edit(null)) {
            echo $referHandler->getHtmlErrors(true, $menu);
        }
        break;
    case 'save':
        unset($_SESSION['wfc_channel']);
        $do_callback->setBasics();
        $do_callback->setValueArray($_REQUEST);
        $do_callback->setValueGroups('refer_read', !empty($_REQUEST['refer_read']) ? $_REQUEST['refer_read'] : [0 => '1']);
        $do_callback->setImage('wfcr_image', $_REQUEST['wfcr_image'], $_REQUEST['imgwidth'], $_REQUEST['imgheight']);

        $ret = $do_callback->htmlClean($do_callback->getValue('wfcr_content'), $_REQUEST['wfc_cleaningoptions']);
        if (null !== $ret) {
            $do_callback->setValue('wfcr_content', $ret);
        }
        if (!$do_callback->save()) {
            echo $referHandler->getHtmlErrors(false, $menu);
        }
        break;
}

//xoosla_cp_footer();
require_once __DIR__ . '/admin_footer.php';
