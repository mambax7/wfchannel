<?php declare(strict_types=1);

/**
 * $Id: notification.inc.php 8179 2011-11-07 00:54:10Z beckmi $
 * Module: WF-Downloads
 * Version: v2.0.5a
 * Release Date: 26 july 2004
 * Author: WF-Sections
 * Licence: GNU
 * @param $category
 * @param $item_id
 * @return array|bool
 */
function wfchannel_notify_iteminfo($category, $item_id)
{
    if (empty($GLOBALS['xoopsModule']) || 'wfchannel' !== $GLOBALS['xoopsModule']->getVar('dirname')) {
        /** @var \XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $module        = $moduleHandler->getByDirname('wfchannel');
        /** @var \XoopsConfigHandler $configHandler */
        $configHandler = xoops_getHandler('config');
        $config        = $configHandler->getConfigsByCat(0, (int)$module->getVar('mid'));
    } else {
        $module = $GLOBALS['xoopsModule'];
        $config = $GLOBALS['xoopsModuleConfig'];
    }
    switch ($category) {
        case 'global':
            return ['name' => '', 'url' => ''];
            break;
        case 'page':
        default:
            $sql    = 'SELECT wfc_cid, wfc_title FROM ' . $GLOBALS['xoopsDB']->prefix('wfcpages') . " WHERE wfc_cid = '" . (int)$item_id . "'";
            $result = $GLOBALS['xoopsDB']->query($sql);
            if ($result) {
                $result_array = $GLOBALS['xoopsDB']->fetchArray($result);
                if ($result_array) {
                    $path = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/index.php?cid=' . (int)$result_array['wfc_cid'];

                    return ['name' => $result_array['wfc_title'], 'url' => $path];
                }
            }

            return false;
            break;
    }
}
