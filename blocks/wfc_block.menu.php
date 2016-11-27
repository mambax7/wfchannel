<?php
// $Id: wfc_block.menu.php 8179 2011-11-07 00:54:10Z beckmi $
// ------------------------------------------------------------------------ //
// WF-Channel - WF-Projects                                                 //
// Copyright (c) 2007 WF-Channel                                            //
// //
// Authors:                                                                 //
// John Neill ( AKA Catzwolf )                                              //
// //
// URL: http://catzwolf.x10hosting.com/                                     //
// Project: WF-Projects                                                     //
// -------------------------------------------------------------------------//
defined('XOOPS_ROOT_PATH') || exit('You do not have permission to access this file!');
/**
 * b_wfc_menu_show()
 *
 * @param  mixed $options
 * @return mixed
 */
function b_wfc_menu_show($options)
{
    $db          = XoopsDatabaseFactory::getDatabaseConnection();
    $user_groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);

    $sql = 'SELECT DISTINCT c.* FROM ' . $db->prefix('wfcpages') . ' c' . "\n LEFT JOIN " . $db->prefix('group_permission') . ' l' . "\n ON l.gperm_itemid = wfc_cid" . "\n AND ( c.wfc_publish = " . $db->quoteString(null) . ' OR c.wfc_publish <= '
           . $db->quoteString(time()) . ' )' . "\n AND ( c.wfc_expired = " . $db->quoteString(null) . ' OR c.wfc_expired >= ' . $db->quoteString(time()) . ' )' . "\n AND c.wfc_submenu = 1" . "\n WHERE ( l.gperm_name = 'page_read'"
           . "\n AND l.gperm_groupid IN ( " . implode(',', $user_groups) . ' ))';
    $sql .= "\n ORDER BY c.wfc_publish DESC";
    $result = $db->query($sql, $options[1], 0);
    while (false !== ($myrow = $db->fetchArray($result))) {
        $new['title']      = xoops_substr($myrow['wfc_title'], 0, $options[2] - 1);
        $new['title_full'] = $myrow['wfc_title'];
        $new['id']         = $myrow['wfc_cid'];
        $block['menu'][]   = $new;
    } // while
    $block['dirname'] = $options[3];

    return $block;
}

/**
 * b_wfc_menu_edit()
 *
 * @param  mixed $options
 * @return string
 */
function b_wfc_menu_edit($options)
{
    $options[3] = !isset($options[3]) ? _MB_WFC_WFCHANNEL : $options[3];

    $form = _MB_WFC_DISP . '&nbsp;';
    $form .= '<input type="hidden" name="options[]" value="';
    $form .= 'wfc_weight"';
    $form .= ' />';
    $form .= '<input type="text" name="options[]" value="' . $options[1] . '" />';
    $form .= '&nbsp;<br>' . _MB_WFC_CHARS . '&nbsp;<input type="text" name="options[]" value="' . $options[2] . '" />';
    $form .= '<input type="hidden" name="options[]" value="wfchannel" />';

    return $form;
}
