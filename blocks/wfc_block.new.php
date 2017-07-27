<?php
// $Id: wfc_block.new.php 8179 2011-11-07 00:54:10Z beckmi $
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
 * b_wfc_new_show()
 *
 * @param  mixed $options
 * @return mixed
 */
function b_wfc_new_show($options)
{
    $db          = XoopsDatabaseFactory::getDatabaseConnection();
    $user_groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);

    $query  = 'SELECT DISTINCT c.* FROM '
              . $db->prefix('wfcpages')
              . ' c'
              . "\n LEFT JOIN "
              . $db->prefix('group_permission')
              . ' l'
              . "\n ON l.gperm_itemid = wfc_cid"
              . "\n AND ( c.wfc_publish = "
              . $db->quoteString(null)
              . ' OR c.wfc_publish <= '
              . $db->quoteString(time())
              . ' )'
              . "\n AND ( c.wfc_expired = "
              . $db->quoteString(null)
              . ' OR c.wfc_expired >= '
              . $db->quoteString(time())
              . ' )'
              . "\n WHERE ( l.gperm_name = 'page_read'"
              . "\n AND l.gperm_groupid IN ( "
              . implode(',', $user_groups)
              . ' ))';
    $query .= "\n ORDER BY c.wfc_publish DESC";
    $result = $db->query($query, $options[1], 0);
    while (false !== ($myrow = $db->fetchArray($result))) {
        $new['title']      = xoops_substr($myrow['wfc_title'], 0, $options[2] - 1);
        $new['title_full'] = $myrow['wfc_title'];
        $new['id']         = $myrow['wfc_cid'];
        $new['date']       = formatTimestamp($myrow['wfc_publish'], $options[3]);
        $block['new'][]    = $new;
    } // while
    $block['dirname'] = $options[4];

    return $block;
}

/**
 * b_wfc_new_edit()
 *
 * @param  mixed $options
 * @return string
 */
function b_wfc_new_edit($options)
{
    $form = _MB_WFC_DISP . '&nbsp;';
    $form .= "<input type='hidden' name='options[]' value='";
    $form .= "wfc_publish'";
    $form       .= '>';
    $form       .= "<input type='text' name='options[]' value='" . $options[1] . "'>";
    $form       .= '&nbsp;<br>' . _MB_WFC_CHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "'>";
    $form       .= '&nbsp;<br>' . _MB_WFC_DATEFORMAT . "&nbsp;<input type='text' name='options[]' value='" . $options[3] . "'>";
    $options[4] = !isset($options[4]) ? 'wfchannel' : $options[4];
    $form       .= '&nbsp;<br>' . _MB_WFC_MODULE . "&nbsp;<input type='text' name='options[]' value='" . $options[4] . "'>";

    return $form;
}
