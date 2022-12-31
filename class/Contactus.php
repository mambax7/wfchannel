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
 * Class Contactus
 */
class Contactus extends Wfresource\WfpObject
{
    private $wfcc_id;
    private $wfcc_titlecont;
    private $wfcc_submenu;
    private $wfcc_mainpage;

    /**
     * XoopsWfPage::XoopsWfPage()
     */
    public function __construct()
    {
        parent::__construct();

        $this->initVar('wfcc_id', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcc_titlecont', \XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('wfcc_submenu', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcc_mainpage', \XOBJ_DTYPE_INT, null, false);
    }
}
