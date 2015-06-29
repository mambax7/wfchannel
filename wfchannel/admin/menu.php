<?php
/**
 * Name: menu.php
 * Description:
 *
 * @package : Xoosla Modules
 * @Module :
 * @subpackage :
 * @since : v1.0.0
 * @author John Neill <catzwolf@xoosla.com>
 * @copyright : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license : GNU/LGPL, see docs/license.php
 * @version : $Id: menu.php 8179 2011-11-07 00:54:10Z beckmi $
 */
defined( 'XOOPS_ROOT_PATH' ) or die( 'Restricted access' );

$adminmenu[0]['title'] = _MA_WFC_ADMENU1;
$adminmenu[0]['link'] = 'admin/index.php';
$adminmenu[1]['title'] = _MA_WFC_ADMENU2;
$adminmenu[1]['link'] = 'admin/index.php?op=edit';
$adminmenu[2]['title'] = _MA_WFC_ADMENU3;
$adminmenu[2]['link'] = 'admin/refer.php';
$adminmenu[3]['title'] = _MA_WFC_ADMENU4;
$adminmenu[3]['link'] = 'admin/link.php';
$adminmenu[4]['title'] = _MA_WFC_ADMENU5;
$adminmenu[4]['link'] = 'admin/permissions.php';
$adminmenu[5]['title'] = _MA_WFC_ADMENU6;
$adminmenu[5]['link'] = 'admin/upload.php';

?>