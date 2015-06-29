<?php
/**
 * Name: link.php
 * Description:
 *
 * @package    : Xoosla Modules
 * @Module     :
 * @subpackage :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 * @version    : $Id: link.php 8179 2011-11-07 00:54:10Z beckmi $
 */
include 'admin_header.php';

$menu_handler->addHeader(_AM_WFCHANNEL_LINKAREA);
$handler     = &wfp_gethandler('link', _MODULE_DIR, _MODULE_CLASS);
$do_callback = wfp_getObjectCallback($handler);

$op = wfp_Request::doRequest($_REQUEST, 'op', 'edit', 'textbox');
switch ($op) {
    case 'edit':
    default:
        $menu = 3;
        $menu_handler->addSubHeader(_AM_WFCHANNEL_LINKAREA_DSC);
        $do_callback->setId(1);
        $do_callback->setMenu($menu);
        if (!call_user_func(array($do_callback, $op), null)) {
            echo $handler->getHtmlErrors(true, $menu);
        }
        break;

    case 'save':
        unset($_SESSION['wfc_channel']);
        $do_callback->setBasics();
        $do_callback->setValueArray($_REQUEST);
        $do_callback->setValueGroups('link_read', !empty($_REQUEST['link_read']) ? $_REQUEST['link_read'] : array(0 => '1'));
        $do_callback->setImage('wfcl_image', $_REQUEST['wfcl_image'], $_REQUEST['imgwidth'], $_REQUEST['imgheight']);

        $ret = $do_callback->htmlClean($do_callback->getValue('wfcl_content'), $_REQUEST['wfc_cleaningoptions']);
        if (null !== $ret) {
            $do_callback->setValue('wfcl_content', $ret);
        }

        if (!call_user_func(array($do_callback, $op), null)) {
            $handler->getHtmlErrors();
        }
        break;
}
xoosla_cp_footer();
