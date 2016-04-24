<?php
/**
 * Name: wfchannel.php
 * Description:
 *
 * @package    : Xoosla Modules
 * @Module     :
 * @subpackage :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 * @param $items
 * @return bool
 */

function wfchannel_tag_iteminfo(&$items)
{
    if (empty($items) || !is_array($items)) {
        return false;
    }
    $upgrade = false;
    include_once XOOPS_ROOT_PATH . '/modules/' . basename(dirname(__DIR__)) . '/include/functions.php';

    $items_id = array();
    foreach (array_keys($items) as $cat_id) {
        foreach (array_keys($items[$cat_id]) as $item_id) {
            $items_id[] = (int)$item_id;
        }
    }
    $handler   = &wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
    $items_obj = $handler->getObjects(new Criteria('wfc_cid', '(' . implode(', ', $items_id) . ')', 'IN'), true);

    foreach (array_keys($items) as $cat_id) {
        foreach (array_keys($items[$cat_id]) as $item_id) {
            if (isset($items_obj[$item_id])) {
                $obj                      = &$items_obj[$item_id];
                $items[$cat_id][$item_id] = array(
                    'title'   => $obj->getVar('wfc_title'),
                    'uid'     => $obj->getVar('wfc_uid'),
                    'link'    => 'index.php?cid=' . $item_id,
                    'time'    => $obj->getVar('wfc_publish'),
                    'tags'    => '', // tag_parse_tag($item_obj->getVar("item_tags", "n")), // optional
                    'content' => ''
                );
            }
        }
    }
    unset($items_obj);
}

/**
 * wfchannel_tag_synchronization()
 *
 * @param mixed $mid
 */
function wfchannel_tag_synchronization($mid)
{
    $item_handler = xoops_getModuleHandler('pages', 'wfchannel');
    $link_handler = xoops_getModuleHandler('link', 'tag');

    /**
     * clear tag-item links
     */
    if ($link_handler->mysql_major_version() >= 4) {
        $sql = "    DELETE FROM {$link_handler->table}" . ' WHERE ' . "     tag_modid = {$mid}" . '     AND ' . '       ( tag_itemid NOT IN ' . "           ( SELECT DISTINCT {$item_handler->keyName} " . "                FROM {$item_handler->table} " . "               WHERE {$item_handler->table}.approved > 0" . '          ) ' . '     )';
    } else {
        $sql = "    DELETE {$link_handler->table} FROM {$link_handler->table}" . "  LEFT JOIN {$item_handler->table} AS aa ON {$link_handler->table}.tag_itemid = aa.{$item_handler->keyName} " . ' WHERE ' . "     tag_modid = {$mid}" . '     AND ' . "       ( aa.{$item_handler->keyName} IS NULL" . '          OR aa.approved < 1' . '     )';
    }
    if (!$result = $link_handler->db->queryF($sql)) {
        // xoops_error($link_handler->db->error());
    }
}
