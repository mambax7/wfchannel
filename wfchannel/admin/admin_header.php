<?php
/**
 * $Id: admin_header.php 8179 2011-11-07 00:54:10Z beckmi $
 * Module: WF-Channel
 * Version: v1.0.5
 * Release Date: 03 Jan 2004
 * Author: Catzwolf
 * Licence: GNU
 */
include dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/include/cp_header.php';
$upgrade = false;
require_once XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar( 'dirname' ) . '/include/functions.php';
/**
 */
$menu_handler = &wfp_gethandler( 'menu' );
// $menu_handler->addMenuTop( 'index.php', _MA_WFP_ADMININDEX );
$menu_handler->addMenuTop( '../index.php', _MA_WFP_MODULEHOME );
$menu_handler->addMenuTop( XOOPS_URL . '/modules/system/admin.php?fct=blocksadmin&selmod=-1&selvis=-1&selgrp=2&selgen=' . $GLOBALS['xoopsModule']->getVar( 'mid' ), _MA_WFP_MODULEBLOCKS );
$menu_handler->addMenuTop( XOOPS_URL . '/modules/system/admin.php?module=' . $GLOBALS['xoopsModule']->getVar( 'mid' ) . '&status=0&limit=10&fct=comments&selsubmit=Go%21', _MA_WFP_ADMINCOMMENTS );
$menu_handler->addMenuTop( XOOPS_URL . '/modules/system/admin.php?fct=tplsets&op=listtpl&tplset=default&moddir=' . $GLOBALS['xoopsModule']->getVar( 'dirname' ), _MA_WFP_MODULETEMPLATE );
$menu_handler->addMenuTop( XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $GLOBALS['xoopsModule']->getVar( 'dirname' ), _MA_WFP_MODULEUPGRADE );

$menu_handler->addMenuIcons( 'help', 'index.php?op=help', _MA_WFP_MODULEHELP );
$menu_handler->addMenuIcons( 'about', 'index.php?op=about', _MA_WFP_MODULEABOUT );
/**
 */
$menu_handler->addMenuTabs( 'index.php', _MA_WFC_ADMINMENU_INDEX );
$menu_handler->addMenuTabs( 'refer.php', _MA_WFC_ADMINMENU_REFER );
$menu_handler->addMenuTabs( 'refers.php', _MA_WFC_ADMINMENU_REFERS );
$menu_handler->addMenuTabs( 'link.php', _MA_WFC_ADMINMENU_LINK );
$menu_handler->addMenuTabs( 'permissions.php', _MA_WFC_ADMINMENU_PERMS );
$menu_handler->addMenuTabs( 'upload.php', _MA_WFC_ADMINMENU_UPLOAD );
$menu_handler->addMenuTabs( 'import.php', _MA_WFC_ADMINMENU_IMPORT );

?>