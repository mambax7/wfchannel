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

use Criteria;
use CriteriaCompo;
use XoopsDatabase;
use XoopsModules\Wfresource;

//wfp_getObjectHandler();

/**
 * RefersHandler
 *
 * @author    John
 * @copyright Copyright (c) 2009
 */
class RefersHandler extends Wfresource\WfpObjectHandler
{
    /**
     * WfchannelPageHandler::XoopsCategoryHandler()
     *
     * @param mixed $db
     */
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'wfcrefers', 'Refers', 'wfcr_id', 'wfcr_ip');
    }

    /**
     * WfchannelReferHandler::getEmailSentCount()
     *
     * @param string $id
     */
    public function getEmailSentCount($id = ''): int
    {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('wfcr_id', $id));

        $_count = $this->getCount($criteria);

        if (is_array($_count)) {
            $ret = $_count['amount'];
        } else {
            $ret = (int)$_count;
        }

        return $ret;
    }

    /**
     * WfchannelReferHandler::getEmailSentCount()
     */
    public function setEmailSendCount(): void
    {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('wfcr_id', 1));
        $this->updateCounter('wfcr_counter', $criteria);
    }

    /**
     * RefersHandler::getObj()
     */
    public function &getObj(...$args): array
    {
        $obj = [];
        if (2 === \func_num_args()) {
//            $args     = \func_get_args();
            $criteria = new CriteriaCompo();
            if (!empty($args[0]['search'])) {
                $searchparms = $args[0]['search'];
                $criteria->add(new Criteria('wfcr_username', "%$searchparms%", 'LIKE'), 'OR');
                $criteria->add(new Criteria('wfcr_ip', "%$searchparms%", 'LIKE'), 'OR');
                $criteria->add(new Criteria('wfcr_referurl', "%$searchparms%", 'LIKE'), 'OR');
            }
            if (!empty($args[0]['date'])) {
                $addon_date = $this->getaDate($args[0]['date']);
                if ($addon_date['begin'] && $addon_date['end']) {
                    $criteria->add(new Criteria('wfcr_date', $addon_date['begin'], '>='), 'AND');
                    $criteria->add(new Criteria('wfcr_date', $addon_date['end'], '<='));
                }
            }
            $obj['count'] = $this->getCount($criteria);
            if (!empty($args[0])) {
                $criteria->setSort($args[0]['sort']);
                $criteria->setOrder($args[0]['order']);
                $criteria->setStart($args[0]['start']);
                $criteria->setLimit($args[0]['limit']);
            }
            $obj['list'] = $this->getObjects($criteria, $args[1]);
        }

        return $obj;
    }

    /**
     * RefersHandler::headingHtml()
     */
    public function headingHtml(...$args): void
    {
        $ret = '';
        if (1 == \func_num_args()) {
            $ret = '<div style="padding-bottom: 8px;">' . \_AM_WFC_TOTALEMAILSSENT . ': <b>' . \func_get_arg(0) . '</b></div>';
        }

        echo $ret;
    }

    /**
     * RefersHandler::getIP()
     */
    public function getIP(): string
    {
        if (\getenv('HTTP_CLIENT_IP')) {
            $ret = \getenv('HTTP_CLIENT_IP');
        } elseif (\getenv('HTTP_X_FORWARDED_FOR')) {
            $ret = \getenv('HTTP_X_FORWARDED_FOR');
        } elseif (\getenv('HTTP_X_FORWARDED')) {
            $ret = \getenv('HTTP_X_FORWARDED');
        } elseif (\getenv('HTTP_FORWARDED_FOR')) {
            $ret = \getenv('HTTP_FORWARDED_FOR');
        } elseif (\getenv('HTTP_FORWARDED')) {
            $ret = \getenv('HTTP_FORWARDED');
        } else {
            $ret = $_SERVER['REMOTE_ADDR'];
        }

        return $ret;
    }
}
