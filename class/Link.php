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

use const ENT_HTML5;
use XoopsModules\Wfresource;

//wfp_getObjectHandler();

/**
 * Link
 *
 * @author    John
 * @copyright Copyright (c) 2007
 */
class Link extends Wfresource\WfpObject
{
    private $wfcl_id;
    private $wfcl_titlelink;
    private $wfcl_submenu;
    private $wfcl_mainpage;
    private $wfcl_textlink;
    private $wfcl_image;
    private $wfcl_button;
    private $wfcl_logo;
    private $wfcl_banner;
    private $wfcl_microbutton;
    private $wfcl_newsfeed;
    private $wfcl_texthtml;
    private $wfcl_newstitle;
    private $wfcl_content;
    private $wfcl_caption;
    private $dohtml;
    private $doxcode;
    private $dosmiley;
    private $doimage;
    private $dobr;

    /**
     * Link::Link()
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('wfcl_id', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcl_titlelink', \XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('wfcl_submenu', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcl_mainpage', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcl_textlink', \XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('wfcl_image', \XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('wfcl_button', \XOBJ_DTYPE_TXTBOX, '||', true, 255);
        $this->initVar('wfcl_logo', \XOBJ_DTYPE_TXTBOX, '||', true, 255);
        $this->initVar('wfcl_banner', \XOBJ_DTYPE_TXTBOX, '||', true, 255);
        $this->initVar('wfcl_microbutton', \XOBJ_DTYPE_TXTBOX, '||', true, 255);
        $this->initVar('wfcl_newsfeed', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('wfcl_texthtml', \XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('wfcl_newstitle', \XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('wfcl_content', \XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('wfcl_caption', \XOBJ_DTYPE_TXTBOX, null, false, 255);

        $this->initVar('dohtml', \XOBJ_DTYPE_INT, 0, false);
        $this->initVar('doxcode', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('dosmiley', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('doimage', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('dobr', \XOBJ_DTYPE_INT, 0, false);
    }

    public function getTextLink(): string
    {
        return '<a href="' . XOOPS_URL . '" target="_blank">' . $this->getVar('wfcl_textlink') . '</a>';
    }

    /**
     * LinkHandler::getImageUrl()
     *
     * @param string $value
     * @param string $dirbase
     */
    public function getImageUrl($value = '', $dirbase = ''): string
    {
        if ($this->getVar($value)) {
            $image = $this->getImage($value, Wfresource\Utility::getModuleOption('linkimages'));
            if ($image && \is_array($image)) {
                return '<a href="' . XOOPS_URL . '" target="_blank"><img style="width: ' . $image['width'] . '; height: ' . $image['height'] . ';" src="' . $image['url'] . '" alt="' . \htmlspecialchars($GLOBALS['xoopsConfig']['sitename'], \ENT_QUOTES | ENT_HTML5) . '"></a>';
            }
        }

        return '';
    }
}
