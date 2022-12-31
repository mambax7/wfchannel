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

//define('SALT_LENGTH', 9);

/**
 * Class Refer
 */
class Refer extends Wfresource\WfpObject
{
    private $wfcr_id;
    private $wfcr_title;
    private $wfcr_content;
    private $wfcr_mainpage;
    private $wfcr_image;
    private $wfcr_email;
    private $wfsr_ublurb;
    private $wfcr_dblurb;
    private $wfcr_privacy;
    private $wfcr_emailcheck;
    private $wfcr_privacytext;
    private $wfcr_counter;
    private $wfcr_caption;
    private $dohtml;
    private $doxcode;
    private $dosmiley;
    private $doimage;
    private $dobr;

    /**
     * XoopsWfPage::XoopsWfPage()
     */
    public function __construct()
    {
        parent::__construct();

        $this->initVar('wfcr_id', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcr_title', \XOBJ_DTYPE_TXTBOX, '', true, 60);
        $this->initVar('wfcr_content', \XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('wfcr_mainpage', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('wfcr_image', \XOBJ_DTYPE_TXTBOX, '', false, 250);
        $this->initVar('wfcr_email', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfsr_ublurb', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcr_dblurb', \XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('wfcr_privacy', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfcr_emailcheck', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfcr_privacytext', \XOBJ_DTYPE_TXTAREA, 0, false);
        $this->initVar('wfcr_counter', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('wfcr_caption', \XOBJ_DTYPE_TXTBOX, null, false, 255);

        $this->initVar('dohtml', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('doxcode', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('dosmiley', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('doimage', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('dobr', \XOBJ_DTYPE_INT, 0, false);
    }
}
