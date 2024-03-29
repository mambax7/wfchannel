<?php declare(strict_types=1);

/**
 * Name: rss.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use XoopsModules\Wfchannel;
use XoopsModules\Wfresource;

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

$GLOBALS['xoopsLogger']->activated = false;
if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}

require_once XOOPS_ROOT_PATH . '/class/template.php';
$tpl          = new \XoopsTpl();
$tpl->caching = 0;
$tpl->xoops_setCacheTime(0);
if (!$tpl->is_cached('db:system_rss.tpl', 'wfc|feed|rss')) {
    xoops_load('XoopsLocal');
    $rssContent = new Wfresource\Rss(); //wfp_getClass('rss');
    $rssContent->basics('module_logo.png', 'modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/images');
    $rss = $rssContent->render();
    foreach ($rss as $key => $value) {
        $tpl->assign($key, $value);
    }

    $handler = new Wfchannel\PageHandler($db); //wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
    $objects = $handler->getList('wfc_publish', 'DESC', 0, 30);
    if (count($objects) > 0) {
        // Get users for items
        // Assign items to template
        $url = XOOPS_URL . '/modules/wfchannel/';
        foreach ($objects as $obj) {
            $link        = $url . 'index.php?cid=' . $obj->getVar('wfc_cid');
            $description = xoops_substr($obj->getVar('wfc_content', 'e'), 0, 200, '...');
            $tpl->append('items', [
                'title'        => xoops_utf8_encode($obj->getVar('wfc_headline', 'e')),
                'author'       => xoops_utf8_encode($obj->getUserName('wfc_uid')),
                'link'         => $link,
                'guid'         => $link,
                'is_permalink' => false,
                'pubdate'      => $obj->getTimestamp('wfc_publish', 'rss'),
                'dc_date'      => $obj->getTimestamp('wfc_publish', 'd/m H:i'),
                'description'  => xoops_utf8_encode($description),
            ]);
        }
    }
}

header('Content-Type:text/xml; charset=utf-8');
$tpl->display('db:system_rss.tpl', 'wfc|feed|rss');
