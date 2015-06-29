<?php
// $Id: class.contactus.php 8179 2011-11-07 00:54:10Z beckmi $
// ------------------------------------------------------------------------ //
// Xoops - PHP Content Management System                      			//
// Copyright (c) 2007 Xoops                           				//
// //
// Authors: 																//
// John Neill ( AKA Catzwolf )                                     			//
// Raimondas Rimkevicius ( AKA Mekdrop )									//
// //
// URL: http:www.Xoops.com 												//
// Project: Xoops Project                                               //
// -------------------------------------------------------------------------//
defined( 'XOOPS_ROOT_PATH' ) or die( 'You do not have permission to access this file!' );

wfp_getObjectHander();

class wfc_Contactus extends wfp_Object {
    /**
     * XoopsWfPage::XoopsWfPage()
     */
    function wfc_Contactus() {
        $this->XoopsObject();

        $this->initVar( 'wfcc_id', XOBJ_DTYPE_INT, null, false );
        $this->initVar( 'wfcc_titlecont', XOBJ_DTYPE_TXTBOX, null, true, 255 );
        $this->initVar( 'wfcc_submenu', XOBJ_DTYPE_INT, null, false );
        $this->initVar( 'wfcc_mainpage', XOBJ_DTYPE_INT, null, false );
    }
}

/**
 * WfchannelContusHandler
 *
 * @package
 * @author John
 * @copyright Copyright (c) 2007
 * @version $Id: class.contactus.php 8179 2011-11-07 00:54:10Z beckmi $
 * @access public
 */
class wfc_ContactusHandler extends wfp_ObjectHandler {
    /**
     * WfchannelContusHandler::ZariliaCategoryHandler()
     *
     * @param mixed $db
     * @return
     */
    function wfc_ContactusHandler( &$db ) {
        $this->wfp_ObjectHandler( $db, 'wfccontus', 'wfc_Contactus', 'wfcc_id', 'wfcc_titlecont' );
    }
}

?>