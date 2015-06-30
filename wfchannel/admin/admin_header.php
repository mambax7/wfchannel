<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 * @version      $Id $
 */

$rootPath = dirname(dirname(dirname(__DIR__)));
include_once $rootPath . '/mainfile.php';
include_once $rootPath . '/include/cp_functions.php';
require_once $rootPath . '/include/cp_header.php';

require_once XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/include/functions.php';
$menu_handler = &wfp_gethandler('menu');

global $xoopsModule;

//$moduleFolder = $GLOBALS['xoopsModule']->getVar('dirname');
$moduleFolder = dirname(__DIR__);
require_once $moduleFolder . '/include/common.php';

//if functions.php file exist
//require_once dirname(__DIR__) . '/include/functions.php';

//$myts = & MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    include_once $GLOBALS['xoops']->path("class/template.php");
    $xoopsTpl = new XoopsTpl();
}

// Load language files
xoops_loadLanguage('admin', $moduleFolder);
xoops_loadLanguage('modinfo', $moduleFolder);
xoops_loadLanguage('main', $moduleFolder);

$pathIcon16      = XOOPS_URL . '/' . $xoopsModule->getInfo('icons16');
$pathIcon32      = XOOPS_URL . '/' . $xoopsModule->getInfo('icons32');
$pathModuleAdmin = XOOPS_ROOT_PATH . '/' . $xoopsModule->getInfo('dirmoduleadmin');
require_once $pathModuleAdmin . '/moduleadmin.php';


$GLOBALS['xoopsTpl']->assign('pathIcon16', $pathIcon16);
$GLOBALS['xoopsTpl']->assign('pathIcon32', $pathIcon32);
