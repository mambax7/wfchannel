<?php
/**
 * Name: list.tag.php
 * Description:
 *
 * @package    : Xoosla Modules
 * @Module     :
 * @subpackage :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 * @version    : $Id: list.tag.php 9326 2012-04-14 21:53:58Z beckmi $
 */
include 'header.php';

if ($GLOBALS['xoopsModuleConfig']['xoopstags'] && file_exists(XOOPS_ROOT_PATH . '/modules/tag/list.tag.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/tag/list.tag.php';
}
