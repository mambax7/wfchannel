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
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

//$path = dirname(dirname(dirname(__DIR__)));
//include_once $path . '/mainfile.php';

$moduleDirName = basename(dirname(__DIR__));

/** @var XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname($moduleDirName);
$pathIcon32    = '../../' . $module->getInfo('sysicons32');
xoops_loadLanguage('modinfo', $module->dirname());

$xoopsModuleAdminPath = XOOPS_ROOT_PATH . '/' . $module->getInfo('dirmoduleadmin');
if (!file_exists($fileinc = $xoopsModuleAdminPath . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/' . 'main.php')) {
    $fileinc = $xoopsModuleAdminPath . '/language/english/main.php';
}
include_once $fileinc;

$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png'
);

$adminmenu[] = array(
    'title' => _MI_WFC_ADMENU1,
    'link'  => 'admin/main.php',
    'icon'  => $pathIcon32 . '/index.png'
);

$adminmenu[] = array(
    'title' => _MI_WFC_ADMENU2,
    'link'  => 'admin/main.php?op=edit',
    'icon'  => $pathIcon32 . '/add.png'
);

$adminmenu[] = array(
    'title' => _MI_WFC_ADMENU3,
    'link'  => 'admin/refer.php',
    'icon'  => $pathIcon32 . '/button_ok.png'
);

$adminmenu[] = array(
    'title' => _MI_WFC_ADMENU8,
    'link'  => 'admin/refers.php',
    'icon'  => $pathIcon32 . '/view_detailed.png'
);

$adminmenu[] = array(
    'title' => _MI_WFC_ADMENU4,
    'link'  => 'admin/link.php',
    'icon'  => $pathIcon32 . '/addlink.png'
);

$adminmenu[] = array(
    'title' => _MI_WFC_ADMENU5,
    'link'  => 'admin/permissions.php',
    'icon'  => $pathIcon32 . '/permissions.png'
);

$adminmenu[] = array(
    'title' => _MI_WFC_ADMENU6,
    'link'  => 'admin/upload.php',
    'icon'  => $pathIcon32 . '/upload.png'
);

$adminmenu[] = array(
    'title' => _MI_WFC_ADMENU7,
    'link'  => 'admin/import.php',
    'icon'  => $pathIcon32 . '/compfile.png'
);

$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png'
);
