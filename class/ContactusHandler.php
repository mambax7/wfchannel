<?php declare(strict_types=1);

namespace XoopsModules\Wfchannel;

// ------------------------------------------------------------------------ //
// Xoops - PHP Content Management System                                //
// Copyright (c) 2007 Xoops                                         //
// //
// Authors:                                                                 //
// John Neill ( AKA Catzwolf )                                              //
// Raimondas Rimkevicius ( AKA Mekdrop )                                    //
// //
// URL: http:www.Xoops.com                                              //
// Project: Xoops Project                                               //
// -------------------------------------------------------------------------//

use XoopsModules\Wfresource;

//wfp_getObjectHandler();

/**
 * WfchannelContusHandler
 *
 * @author    John
 * @copyright Copyright (c) 2007
 */
class ContactusHandler extends Wfresource\WfpObjectHandler
{
    /**
     * WfchannelContusHandler::ZariliaCategoryHandler()
     *
     * @param mixed $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wfccontus', Contactus::class, 'wfcc_id', 'wfcc_titlecont');
    }
}
