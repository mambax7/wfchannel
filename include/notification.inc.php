<?php
/**
 * $Id: notification.inc.php 8179 2011-11-07 00:54:10Z beckmi $
 * Module: WF-Downloads
 * Version: v2.0.5a
 * Release Date: 26 july 2004
 * Author: WF-Sections
 * Licence: GNU
 */

function wfchannel_notify_iteminfo($category, $item_id)
{
    if (empty($GLOBALS['xoopsModule']) || $GLOBALS['xoopsModule']->getVar('dirname') != 'wfchannel') {
        $module_handler = &xoops_gethandler('module');
        $module         = &$module_handler->getByDirname('wfchannel');
        $config_handler = &xoops_gethandler('config');
        $config         = &$config_handler->getConfigsByCat(0, (int)($module->getVar('mid')));
    } else {
        $module = &$GLOBALS['xoopsModule'];
        $config = &$GLOBALS['xoopsModuleConfig'];
    }
    switch ($category) {
        case 'global':
            return array('name' => '', 'url' => '');
            break;

        case 'page':
        default:
            $sql    = "SELECT wfc_cid, wfc_title FROM " . $GLOBALS['xoopsDB']->prefix('wfcpages') . " WHERE wfc_cid = '" . (int)$item_id . "'";
            $result = $GLOBALS['xoopsDB']->query($sql);
            if ($result) {
                $result_array = $GLOBALS['xoopsDB']->fetchArray($result);
                if ($result_array) {
                    $path = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/index.php?cid=' . (int)$result_array['wfc_cid'];

                    return array('name' => $result_array['wfc_title'], 'url' => $path);
                }
            }

            return false;
            break;
    }
}
