<?php
/**
 * Name: comment_functions.php
 * Description:
 *
 * @package    : Xoosla Modules
 * @Module     :
 * @subpackage :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 * @version    : $Id: comment_functions.php 8179 2011-11-07 00:54:10Z beckmi $
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * wfchannel_com_update()
 *
 * @param mixed $wfc_cid
 * @param mixed $total_num
 * @return
 */
function wfchannel_com_update($wfc_cid, $total_num)
{
    $db  = &XoopsDatabaseFactory::getDatabaseConnection();
    $sql = 'UPDATE ' . $db->prefix('wfcpages') . ' SET wfc_comments = ' . (int)$total_num . ' WHERE wfc_cid = ' . (int)$wfc_cid;
    $db->query($sql);
}
