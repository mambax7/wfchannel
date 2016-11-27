<?php
/**
 * Name: sitemap.plugin.php
 * Description:
 *
 * @package    : Xoosla Modules
 * @Module     :
 * @subpackage :
 * @since      : v1.0.0
 * @author     J.E. Garrett <jim@zyspec.com>
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * b_sitemap_wfchannel()
 * @return array
 */
function b_sitemap_wfchannel()
{
    require_once XOOPS_ROOT_PATH . '/modules/wfchannel/include/functions.php';
    $pageHandler = wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
    $obj          = $pageHandler->getPageObj('', false);
    $ret          = array();
    if ($obj['count'] && count($obj['list'])) {
        foreach ($obj['list'] as $obj) {
            $wfc_cid         = $obj->getVar('wfc_cid');
            $ret['parent'][] = array(
                'id'    => $wfc_cid,
                'title' => $obj->getVar('wfc_title'),
                'url'   => 'index.php?wfc_id=' . $wfc_cid
            );
        }
    }

    return $ret;
}
