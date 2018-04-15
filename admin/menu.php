<?php
/**
 * Name: menu.php
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

use XoopsModules\Wfchannel;

// require_once  dirname(__DIR__) . '/class/Helper.php';
//require_once  dirname(__DIR__) . '/include/common.php';
$helper = Wfchannel\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');


$adminmenu[] = [
    'title' => _MI_WFC_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png'
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU1,
    'link'  => 'admin/main.php',
    'icon'  => $pathIcon32 . '/index.png'
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU2,
    'link'  => 'admin/main.php?op=edit',
    'icon'  => $pathIcon32 . '/add.png'
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU3,
    'link'  => 'admin/refer.php',
    'icon'  => $pathIcon32 . '/button_ok.png'
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU8,
    'link'  => 'admin/refers.php',
    'icon'  => $pathIcon32 . '/view_detailed.png'
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU4,
    'link'  => 'admin/link.php',
    'icon'  => $pathIcon32 . '/addlink.png'
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU5,
    'link'  => 'admin/permissions.php',
    'icon'  => $pathIcon32 . '/permissions.png'
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU6,
    'link'  => 'admin/upload.php',
    'icon'  => $pathIcon32 . '/upload.png'
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU7,
    'link'  => 'admin/import.php',
    'icon'  => $pathIcon32 . '/compfile.png'
];

$adminmenu[] = [
    'title' => _MI_WFC_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png'
];
