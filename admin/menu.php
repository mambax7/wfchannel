<?php declare(strict_types=1);

/**
 * Name: menu.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use Xmf\Module\Admin;
use XoopsModules\Wfchannel\Helper;

/** @var Admin $adminObject */
/** @var Helper $helper */
include \dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = \basename(\dirname(__DIR__));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

$helper = Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32    = Admin::menuIconPath('');
$pathModIcon32 = XOOPS_URL . '/modules/' . $moduleDirName . '/assets/images/icons/32/';
if (is_object($helper->getModule()) && false !== $helper->getModule()->getInfo('modicons32')) {
    $pathModIcon32 = $helper->url($helper->getModule()->getInfo('modicons32'));
}

$adminmenu[] = [
    'title' => _MI_WFC_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU1,
    'link'  => 'admin/main.php',
    'icon'  => $pathIcon32 . '/index.png',
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU2,
    'link'  => 'admin/main.php?op=edit',
    'icon'  => $pathIcon32 . '/add.png',
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU3,
    'link'  => 'admin/refer.php',
    'icon'  => $pathIcon32 . '/button_ok.png',
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU8,
    'link'  => 'admin/refers.php',
    'icon'  => $pathIcon32 . '/view_detailed.png',
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU4,
    'link'  => 'admin/link.php',
    'icon'  => $pathIcon32 . '/addlink.png',
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU5,
    'link'  => 'admin/permissions.php',
    'icon'  => $pathIcon32 . '/permissions.png',
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU6,
    'link'  => 'admin/upload.php',
    'icon'  => $pathIcon32 . '/upload.png',
];

$adminmenu[] = [
    'title' => _MI_WFC_ADMENU7,
    'link'  => 'admin/import.php',
    'icon'  => $pathIcon32 . '/compfile.png',
];
// Blocks Admin
$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
    'link' => 'admin/blocksadmin.php',
    'icon' => $pathIcon32 . '/block.png',
];

if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE'),
        'link' => 'admin/migrate.php',
        'icon' => $pathIcon32 . '/database_go.png',
    ];
}

$adminmenu[] = [
    'title' => _MI_WFC_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
