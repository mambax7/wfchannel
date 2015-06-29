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
 * @version    : $Id: menu.php 8179 2011-11-07 00:54:10Z beckmi $
 */
defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

//$path = dirname(dirname(dirname(__DIR__)));
//include_once $path . '/mainfile.php';

$module_handler = xoops_gethandler('module');
$module         = $module_handler->getByDirname(basename(dirname(__DIR__)));
$pathIcon32     = '../../' . $module->getInfo('icons32');
xoops_loadLanguage('modinfo', $module->dirname());

$pathModuleAdmin = XOOPS_ROOT_PATH . '/' . $module->getInfo('dirmoduleadmin') . '/moduleadmin';
if (!file_exists($fileinc = $pathModuleAdmin . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/' . 'main.php')) {
    $fileinc = $pathModuleAdmin . '/language/english/main.php';
}
include_once $fileinc;

$adminmenu              = array();
$i                      = 0;
$adminmenu[$i]["title"] = _AM_MODULEADMIN_HOME;
$adminmenu[$i]['link']  = "admin/index.php";
$adminmenu[$i]["icon"]  = $pathIcon32 . '/home.png';
++$i;
$adminmenu[$i]['title'] = _MI_WFCHANNEL_ADMENU2;
$adminmenu[$i]['link']  = 'admin/main.php?op=edit';
$adminmenu[$i]["icon"]  = $pathIcon32 . '/manage.png';
++$i;
$adminmenu[$i]['title'] = _MI_WFCHANNEL_ADMENU3;
$adminmenu[$i]['link']  = 'admin/refer.php';
$adminmenu[$i]["icon"]  = $pathIcon32 . '/button_ok.png';
++$i;
$adminmenu[$i]['title'] = _MI_WFCHANNEL_ADMENU4;
$adminmenu[$i]['link']  = 'admin/link.php';
$adminmenu[$i]["icon"]  = $pathIcon32 . '/addlink.png';
++$i;
$adminmenu[$i]['title'] = _MI_WFCHANNEL_ADMENU5;
$adminmenu[$i]['link']  = 'admin/permissions.php';
$adminmenu[$i]["icon"]  = $pathIcon32 . '/permissions.png';
++$i;
$adminmenu[$i]['title'] = _MI_WFCHANNEL_ADMENU6;
$adminmenu[$i]['link']  = 'admin/upload.php';
$adminmenu[$i]["icon"]  = $pathIcon32 . '/download.png';
++$i;
$adminmenu[$i]['title'] = _MI_WFCHANNEL_ADMENU7;
$adminmenu[$i]['link']  = 'admin/import.php';
$adminmenu[$i]["icon"]  = $pathIcon32 . '/compfile.png';
++$i;
$adminmenu[$i]['title'] = _AM_MODULEADMIN_ABOUT;
$adminmenu[$i]["link"]  = "admin/about.php";
$adminmenu[$i]["icon"]  = $pathIcon32 . '/about.png';
