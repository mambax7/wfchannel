<?php
// $Id: class.link.php 8179 2011-11-07 00:54:10Z beckmi $
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
defined('XOOPS_ROOT_PATH') || exit('You do not have permission to access this file!');

wfp_getObjectHandler();

/**
 * wfc_Link
 *
 * @package
 * @author    John
 * @copyright Copyright (c) 2007
 * @access    public
 */
class wfc_Link extends wfp_Object
{
    /**
     * wfc_Link::wfc_Link()
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('wfcl_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcl_titlelink', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('wfcl_submenu', XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcl_mainpage', XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcl_textlink', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('wfcl_image', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('wfcl_button', XOBJ_DTYPE_TXTBOX, '||', true, 255);
        $this->initVar('wfcl_logo', XOBJ_DTYPE_TXTBOX, '||', true, 255);
        $this->initVar('wfcl_banner', XOBJ_DTYPE_TXTBOX, '||', true, 255);
        $this->initVar('wfcl_microbutton', XOBJ_DTYPE_TXTBOX, '||', true, 255);
        $this->initVar('wfcl_newsfeed', XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcl_texthtml', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('wfcl_newstitle', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('wfcl_content', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('wfcl_caption', XOBJ_DTYPE_TXTBOX, null, false, 255);
        /**
         */
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('doxcode', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('dosmiley', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('doimage', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('dobr', XOBJ_DTYPE_INT, 0, false);
    }

    /**
     * @return string
     */
    public function getTextLink()
    {
        return '<a href="' . XOOPS_URL . '" target="_blank">' . $this->getVar('wfcl_textlink') . '</a>';
    }

    /**
     * wfc_LinkHandler::getImageUrl()
     *
     * @param  string $value
     * @param  string $dirbase
     * @return string
     */
    public function getImageUrl($value = '', $dirbase = '')
    {
        if ($this->getVar($value)) {
            $image = $this->getImage($value, wfp_getModuleOption('linkimages'));
            if (is_array($image) && count($image) > 0) {
                return '<a href="' . XOOPS_URL . '" target="_blank"><img style="width: ' . $image['width'] . '; height: ' . $image['height'] . ';" src="' . $image['url'] . '" alt="' . htmlspecialchars($GLOBALS['xoopsConfig']['sitename']) . '"></a>';
            }
        }

        return '';
    }
}

/**
 * wfc_LinkHandler
 *
 * @package
 * @author    John
 * @copyright Copyright (c) 2007
 * @access    public
 */
class wfc_LinkHandler extends wfp_ObjectHandler
{
    /**
     * wfc_LinkHandler::XoopsCategoryHandler()
     *
     * @param mixed $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'wfclink', 'wfc_Link', 'wfcl_id', 'wfcl_titlelink', 'link_read');
    }
}
