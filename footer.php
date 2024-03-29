<?php declare(strict_types=1);

// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <https://xoops.org>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //

$xoopsTpl->assign('icon_dirname', 'wfresource');
$xoops_module_header = '
<link rel="stylesheet" type="text/css" href="' . XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/css/module.css">
<link rel="alternate" type="application/rss+xml" title="' . $xoopsModule->getVar('name') . ' rss" href="' . XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/rss.php">
<link rel="alternate" type="application/rss+xml" title="' . $xoopsModule->getVar('name') . ' rdf" href="' . XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/rss.php">
<link rel="alternate" type="application/atom+xml" title="' . $xoopsModule->getVar('name') . ' atom" href="' . XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/rss.php">';
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);
require_once XOOPS_ROOT_PATH . '/footer.php';
