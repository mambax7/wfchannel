<?php
/**
 * $Id: search.inc.php 8179 2011-11-07 00:54:10Z beckmi $
 * Module: WF-Channel
 * Version: v1.0.5
 * Release Date: 03 Jan 2004
 * Author: Catzwolf
 * Licence: GNU
 */

defined('XOOPS_ROOT_PATH') || exit('You do not have permission to access this file!');
/**
 * wfchannel_search()
 *
 * @param  mixed $queryarray
 * @param  mixed $andor
 * @param  mixed $limit
 * @param  mixed $offset
 * @param  mixed $userid
 * @return array|string
 */
function wfchannel_search($queryarray, $andor, $limit, $offset, $userid)
{
    $upgrade = false;
    require_once XOOPS_ROOT_PATH . '/modules/wfchannel/include/functions.php';

    $ret = '';
    if (!isset($pageHandler)) {
        $pageHandler = wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
    }
    $page_search = $pageHandler->getSearch($queryarray, $andor, $limit, $offset, true);

    $i = 0;

    $ret = array();
    if (!empty($page_search['list'])) {
        foreach ($page_search['list'] as $obj) {
            $ret[$i]['link']  = 'index.php?wfc_cid=' . $obj->getVar('wfc_cid');
            $ret[$i]['title'] = $obj->getVar('wfc_headline');
            $ret[$i]['time']  = $obj->getVar('wfc_publish');
            $ret[$i]['uid']   = $obj->getVar('wfc_uid');
            ++$i;
        }
    }

    return $ret;
}
