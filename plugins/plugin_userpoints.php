<?php
/**
 * Name: Untitled 1.php
 * Description:
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  XOOPS Project (https://xoops.org)
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    : XOOPS
 * @Module     :
 * @subpackage :
 * @since      2.3.0
 * @author     John Neill
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * @param         $uid
 * @param  string $startdate
 * @return array
 */
function wfchannel_getUserPoints($uid, $startdate = '')
{
    require_once XOOPS_ROOT_PATH . '/modules/wfchannel/include/functions.php';

    $downloadHandler = wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
    if (empty($startdate)) {
        $startdate = strtotime(date('m-y-Y'));
    }

    $criteriaPublished = new CriteriaCompo();
    $criteriaPublished->add(new Criteria('wfc_publish', 0, '>'));
    $criteriaPublished->add(new Criteria('wfc_publish', $startdate, '<='));

    $criteriaExpired = new CriteriaCompo();
    $criteriaExpired->add(new Criteria('wfc_expired', 0, '='));
    $criteriaExpired->add(new Criteria('wfc_expired', time(), '>'), 'OR');

    $criteria = new CriteriaCompo();
    $criteria->add($criteriaPublished);
    $criteria->add($criteriaExpired);
    $criteria->add(new Criteria('wfc_active', 1, '='));
    $criteria->add(new Criteria('wfc_uid', $uid, '='));
    $itemcount = $downloadHandler->getCount($criteria);

    $ret = array();
    /**
     * Get module items count for the user
     */
    $ret['itemcount'] = $itemcount;
    /**
     * Get Vote count for user
     */
    $ret['votes'] = 0;

    /**
     * Return
     */

    return $ret;
}
