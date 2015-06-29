<?php
// ------------------------------------------------------------------------ //
// Xoops - PHP Content Management System                      			//
// Copyright (c) 2007 Xoops                           				//
// //
// Authors: 																//
// John Neill ( AKA Catzwolf )                                     			//
// Raimondas Rimkevicius ( AKA Mekdrop )									//
// //
// URL: http:www.Xoops.com 												//
// Project: Xoops Project                                               //
// -------------------------------------------------------------------------//
include dirname( dirname( dirname( __FILE__ ) ) ) . DIRECTORY_SEPARATOR . 'mainfile.php';
$upgrade = false;
include_once XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar( 'dirname' ) . '/include/functions.php';

?>