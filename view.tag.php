<?php declare(strict_types=1);

/**
 * Name: view.tag.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */
require_once __DIR__ . '/header.php';

if ($GLOBALS['xoopsModuleConfig']['xoopstags'] && file_exists(XOOPS_ROOT_PATH . '/modules/tag/view.tag.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/tag/view.tag.php';
}
