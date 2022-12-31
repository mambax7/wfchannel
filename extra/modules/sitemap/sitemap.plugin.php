<?php declare(strict_types=1);

/**
 * Name: sitemap.plugin.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     J.E. Garrett <jim@zyspec.com>
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use XoopsModules\Wfchannel;

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * b_sitemap_wfchannel()
 * @return array
 */
function b_sitemap_wfchannel()
{
    require_once XOOPS_ROOT_PATH . '/modules/wfchannel/include/functions.php';
    $pageHandler = new Wfchannel\PageHandler($db); //wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
    $obj         = $pageHandler->getPageObj('', false);
    $ret         = [];
    if ($obj['count'] && count($obj['list'])) {
        foreach ($obj['list'] as $obj) {
            $wfc_cid         = $obj->getVar('wfc_cid');
            $ret['parent'][] = [
                'id'    => $wfc_cid,
                'title' => $obj->getVar('wfc_title'),
                'url'   => 'index.php?wfc_id=' . $wfc_cid,
            ];
        }
    }

    return $ret;
}
