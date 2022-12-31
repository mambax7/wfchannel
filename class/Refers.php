<?php declare(strict_types=1);

namespace XoopsModules\Wfchannel;

/**
 * Name: class.refers.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use XoopsModules\Wfresource;

//wfp_getObjectHandler();

/**
 * WfchannelRefers
 *
 * @author    John
 * @copyright Copyright (c) 2007
 */
class Refers extends Wfresource\WfpObject
{
    private $wfcr_id;
    private $wfcr_username;
    private $wfcr_uid;
    private $wfcr_referurl;
    private $wfcr_date;
    private $wfcr_ip;

    /**
     * XoopsWfPage::XoopsWfPage()
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('wfcr_id', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcr_username', \XOBJ_DTYPE_TXTBOX, null, true, 60);
        $this->initVar('wfcr_uid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcr_referurl', \XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('wfcr_date', \XOBJ_DTYPE_TXTBOX, null, true, 60);
        $this->initVar('wfcr_ip', \XOBJ_DTYPE_TXTBOX, null, true, 60);
    }

    /**
     * WfchannelRefers::getUid()
     * @return mixed|string
     */
    public function getUid()
    {
        if ($this->getVar('wfcr_username')) {
            return $this->getVar('wfcr_username');
        }

        return \XoopsUserUtility::getUnameFromId($this->getVar('wfcr_uid'));
    }

    /**
     * WfchannelRefers::getReferUrl()
     */
    public function getReferUrl(): string
    {
        if (!$this->getVar('wfcr_referurl')) {
            return '';
        }
        $URL = \parse_url($this->getVar('wfcr_referurl'));

        return $URL['host'] ?? 'Unknown Host';
    }
}
