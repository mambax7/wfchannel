<?php
/**
 * Name: form_wfc_link.php
 * Description:
 *
 * @package    : Xoosla Modules
 * @Module     :
 * @subpackage :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */
defined('XOOPS_ROOT_PATH') || die('Restricted access');

$form = new \XoopsThemeTabForm(_AM_WFC_CMODIFYLINK, 'op', 'link.php');
$form->setExtra('enctype="multipart/form-data"');
$form->doTabs();
/**
 * hiddenvalues
 */
$form->addElement(new \XoopsFormHiddenToken());
$form->addElement(new xoopsFormHidden('op', 'save'));
$form->addElement(new xoopsFormHidden('wfcl_id', $this->getVar('wfcl_id')));

/**
 * First Fields
 */
$form->startTab('Main', 'main-info');
/**
 * Title Element
 */
$wfcl_titlelink = new \XoopsFormText(_AM_EWFC_LINK_TITLE, 'wfcl_titlelink', 50, 255, $this->getVar('wfcl_titlelink', 'e'));
$wfcl_titlelink->setDescription(_AM_EWFC_LINK_TITLE_DSC);
$form->addElement($wfcl_titlelink, true);

/**
 * Refer Content
 */
$options = [
    'name'   => 'wfcl_content',
    'value'  => $this->getVar('wfcl_content', 'e'),
    'rows'   => 35,
    'cols'   => 75,
    'width'  => '100%',
    'height' => '400px'
];

$options_tray = new \XoopsFormElementTray(_AM_EWFC_LINK_INTRO, '');
$options_tray->setNocolspan(1);
$wfc_content = new \XoopsFormEditor('', wfp_getModuleOption('use_wysiwyg'), $options, $nohtml = false, 'textarea');
$options_tray->addElement($wfc_content);

if (true === wfp_isEditorHTML()) {
    $options_tray->addElement(new xoopsFormHidden('dohtml', 1));
    $options_tray->addElement(new xoopsFormHidden('dobr', 0));
} else {
    $html_checkbox = new \XoopsFormCheckBox('', 'dohtml', $this->getVar('dohtml'));
    $html_checkbox->addOption(1, _AM_EWFP_DOHTML);
    $options_tray->addElement($html_checkbox);
    $breaks_checkbox = new \XoopsFormCheckBox('', 'dobr', $this->getVar('dobr'));
    $breaks_checkbox->addOption(1, _AM_EWFP_BREAKS);
    $options_tray->addElement($breaks_checkbox);
}
$xcodes_checkbox = new \XoopsFormCheckBox('', 'doxcode', $this->getVar('doxcode'));
$xcodes_checkbox->addOption(1, _AM_EWFP_DOXCODE);
$options_tray->addElement($xcodes_checkbox);
$smiley_checkbox = new \XoopsFormCheckBox('', 'dosmiley', $this->getVar('dosmiley'));
$smiley_checkbox->addOption(1, _AM_EWFP_DOSMILEY);
$options_tray->addElement($smiley_checkbox);
$form->addElement($options_tray, false);

$clean_select = new \XoopsFormSelect(_AM_EWFC_CLEANINGOPTIONS, 'wfc_cleaningoptions', 0);
$clean_select->setDescription(_AM_EWFC_CLEANINGOPTIONS_DSC);
$clean_select->addOption(0, _AM_EWFC_CLEANRAW);
$clean_select->addOption(1, _AM_EWFC_CLEANHTML);
$clean_select->addOption(2, _AM_EWFC_CLEANMSWORD);
$clean_select->addOption(3, _AM_EWFC_CLEANALL);
$form->addElement($clean_select);

/**
 */
$wfcl_mainpage = new \XoopsFormRadioYN(_AM_EWFC_LINK_MENU, 'wfcl_mainpage', $this->getVar('wfcl_mainpage'), ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
$wfcl_mainpage->setDescription(_AM_EWFC_LINK_MENU_DSC);
$form->addElement($wfcl_mainpage, false);
/**
 * Submit buttons
 */
$form->addElement(new \XoopsFormButtontray('submit', _SUBMIT));
$form->endTab();
/**
 */
$form->startTab('Logos', 'main-published');
/**
 */
$wfcl_textlink = new \XoopsFormText(_AM_EWFC_LINK_TEXTLINK, 'wfcl_textlink', 50, 255, $this->getVar('wfcl_textlink', 'e'));
$wfcl_textlink->setDescription(_AM_EWFC_LINK_TEXTLINK_DSC);
$form->addElement($wfcl_textlink, true);
/**
 */
$wfcl_button = new \XoopsFormSelectImage(_AM_EWFC_LINK_BUTTONLINK, 'wfcl_button', $this->getVar('wfcl_button', 'e'), 'xoops_image2', 0, 5);
$wfcl_button->setDescription(_AM_EWFC_LINK_BUTTONLINK_DSC);
$wfcl_button->setCategory(wfp_getModuleOption('linkimages'));
$form->addElement($wfcl_button, false);
/**
 */
$wfcl_logo = new \XoopsFormSelectImage(_AM_EWFC_LINK_LOGOLINK, 'wfcl_logo', $this->getVar('wfcl_logo', 'e'), 'xoops_image3', 0, $size = 5);
$wfcl_logo->setDescription(_AM_EWFC_LINK_LOGOLINK_DSC);
$wfcl_logo->setCategory(wfp_getModuleOption('linkimages'));
$form->addElement($wfcl_logo, false);
/**
 */
$wfcl_banner = new \XoopsFormSelectImage(_AM_EWFC_LINK_BANNERLINK, 'wfcl_banner', $this->getVar('wfcl_banner', 'e'), 'xoops_image4', 0, $size = 5);
$wfcl_banner->setDescription(_AM_EWFC_LINK_BANNERLINK_DSC);
$wfcl_banner->setCategory(wfp_getModuleOption('linkimages'));
$form->addElement($wfcl_banner, false);
/**
 */
$wfcl_microbutton = new \XoopsFormSelectImage(_AM_EWFC_LINK_MICROLINK, 'wfcl_microbutton', $this->getVar('wfcl_microbutton', 'e'), 'xoops_image5', 0, $size = 5);
$wfcl_microbutton->setDescription(_AM_EWFC_LINK_MICROLINK_DSC);
$wfcl_microbutton->setCategory(wfp_getModuleOption('linkimages'));
$form->addElement($wfcl_microbutton, false);

/**
 */
$wfcl_newsfeed = new \XoopsFormRadioYN(_AM_EWFC_LINK_NEWSFEED, 'wfcl_newsfeed', $this->getVar('wfcl_newsfeed', 'e'), ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
$wfcl_newsfeed->setDescription(_AM_EWFC_LINK_NEWSFEED_DSC);
$form->addElement($wfcl_newsfeed, false);

/**
 * Submit buttons
 */
$form->addElement(new \XoopsFormButtontray('submit', _SUBMIT));
$form->endTab();

$form->startTab(_AM_WFC_TABIMAGE, 'main-image');
/**
 * Page Image
 */
$wfcl_image = new \XoopsFormSelectImage(_AM_EWFC_PAGE_LOGO, 'wfcl_image', $this->getVar('wfcl_image', 'e'), 'xoops_image', 0, $size = 5);
$wfcl_image->setDescription(_AM_EWFC_PAGE_LOGO_DSC);
$wfcl_image->setCategory(wfp_getModuleOption('uploaddir'));
$form->addElement($wfcl_image, false);

$image = $this->getImageEdit('wfc_image');

$wfcl_imgwidth = new \XoopsFormText(_AM_EWFC_MENU_IMGWIDTH, 'imgwidth', 5, 5, $image['width']);
$wfcl_imgwidth->setDescription(_AM_EWFC_MENU_IMGWIDTH_DSC);
$form->addElement($wfcl_imgwidth, false);

$wfcl_imgheight = new \XoopsFormText(_AM_EWFC_MENU_IMGHEIGHT, 'imgheight', 5, 5, $image['height']);
$wfcl_imgheight->setDescription(_AM_EWFC_MENU_IMGHEIGHT_DSC);
$form->addElement($wfcl_imgheight, false);

$wfcl_caption = new \XoopsFormText(_AM_EWFC_MENU_CAPTION, 'wfcl_caption', 50, 150, $this->getVar('wfcl_caption', 'e'));
$wfcl_caption->setDescription(_AM_EWFC_MENU_CAPTION_DSC);
$form->addElement($wfcl_caption, false);

$form->addElement(new \XoopsFormButtontray('submit', _SUBMIT));
$form->endTab();

/**
 */
$form->startTab('Permissions', 'main-permissions');
/**
 */
$group = wfp_getClass('permissions');
$group->setPermissions('wfclink', 'link_read', '', $GLOBALS['xoopsModule']->getVar('mid'));
$groups = new \XoopsFormSelectCheckGroup(_AM_EWFP_GROUPS, 'link_read', $group->getAdmin($this->getVar('wfcl_id')), '', true);
$groups->setDescription(_AM_EWFP_GROUPS_DSC);
$form->addElement($groups);
/**
 * Submit buttons
 */
$form->addElement(new \XoopsFormButtontray('submit', _SUBMIT));
$form->endTab();
/**
 * Display
 */
$form->display();
