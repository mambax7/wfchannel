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

use XoopsDatabase;
use XoopsModules\Wfresource;

//wfp_getObjectHandler();

/**
 * LinkHandler
 *
 * @author    John
 * @copyright Copyright (c) 2007
 */
class LinkHandler extends Wfresource\WfpObjectHandler
{
    /**
     * LinkHandler::XoopsCategoryHandler()
     *
     * @param mixed $db
     */
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'wfclink', Link::class, 'wfcl_id', 'wfcl_titlelink', 'link_read');
    }
}
