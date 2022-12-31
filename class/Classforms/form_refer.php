<?php declare(strict_types=1);

namespace XoopsModules\Wfchannel\Classforms;

/**
 * Name: form_wfc_refer.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use XoopsModules\Wfresource\Xoopsforms;
use XoopsModules\Wfresource;

\defined('XOOPS_ROOT_PATH') || exit('Restricted access');

$form = new Xoopsforms\XoopsThemeTabForm(\_AM_WFC_CMODIFYREFER, 'op', 'refer.php');
$form->setExtra('enctype="multipart/form-data"');
$form->doTabs();
#/**
# * Hidden elements
# */
$form->addElement(new \XoopsFormHiddenToken());
$form->addElement(new \XoopsFormHidden('op', 'save'));
$form->addElement(new \XoopsFormHidden('wfcr_id', $this->getVar('wfcr_id')));

// ------------------------ MAIN ----------------------------------------

#/**
# * Main Elements
# */
$form->startTab(\_AM_WFC_TABMAIN, 'main-info');
#/**
# * Refer Title
# */
$wfcr_title = new \XoopsFormText(\_AM_EWFC_REFER_TITLE, 'wfcr_title', 50, 255, $this->getVar('wfcr_title', 'e'));
$wfcr_title->setDescription(\_AM_EWFC_REFER_TITLE_DSC);
$form->addElement($wfcr_title, true);
#
#/**
# * Refer Content
# */
$options_tray = new \XoopsFormElementTray(\_AM_EWFC_REFER_INTRO, '<br>');
$options_tray->setNocolspan(1);
if (\class_exists('XoopsFormEditor')) {
    $options['name']   = 'wfcr_content';
    $options['value']  = $this->getVar('wfcr_content', 'e');
    $options['rows']   = 25;
    $options['cols']   = 60;
    $options['width']  = '100%';
    $options['height'] = '400px';
    $wfc_content       = new \XoopsFormEditor('', Wfresource\Utility::getModuleOption('use_wysiwyg'), $options, $nohtml = false, 'textarea');
    $options_tray->addElement($wfc_content);
} else {
    $wfc_content = new \XoopsFormDhtmlTextArea('', 'wfcr_content', $this->getVar('wfcr_content', 'e'), 15, 60);
    $options_tray->addElement($wfc_content);
}
if (true === Wfresource\Utility::isEditorHTML()) {
    $options_tray->addElement(new \XoopsFormHidden('dohtml', 1));
    $options_tray->addElement(new \XoopsFormHidden('dobr', 0));
} else {
    $html_checkbox = new \XoopsFormCheckBox('', 'dohtml', $this->getVar('dohtml'));
    $html_checkbox->addOption(1, \_AM_EWFP_DOHTML);
    $options_tray->addElement($html_checkbox);
    $breaks_checkbox = new \XoopsFormCheckBox('', 'dobr', $this->getVar('dobr'));
    $breaks_checkbox->addOption(1, \_AM_EWFP_BREAKS);
    $options_tray->addElement($breaks_checkbox);
}
$xcodes_checkbox = new \XoopsFormCheckBox('', 'doxcode', $this->getVar('doxcode'));
$xcodes_checkbox->addOption(1, \_AM_EWFP_DOXCODE);
$options_tray->addElement($xcodes_checkbox);
$smiley_checkbox = new \XoopsFormCheckBox('', 'dosmiley', $this->getVar('dosmiley'));
$smiley_checkbox->addOption(1, \_AM_EWFP_DOSMILEY);
$options_tray->addElement($smiley_checkbox);
$form->addElement($options_tray, false);

$clean_select = new \XoopsFormSelect(\_AM_EWFC_CLEANINGOPTIONS, 'wfc_cleaningoptions', 0);
$clean_select->setDescription(\_AM_EWFC_CLEANINGOPTIONS_DSC);
$clean_select->addOption(0, \_AM_EWFC_CLEANRAW);
$clean_select->addOption(1, \_AM_EWFC_CLEANHTML);
$clean_select->addOption(2, \_AM_EWFC_CLEANMSWORD);
$clean_select->addOption(3, \_AM_EWFC_CLEANALL);
$form->addElement($clean_select);

/**
 * Refer Main Page item
 */
$wfcr_mainpage = new \XoopsFormRadioYN(\_AM_EWFC_REFER_MENU, 'wfcr_mainpage', $this->getVar('wfcr_mainpage'), ' ' . \_AM_WFP_YES, ' ' . \_AM_WFP_NO);
$wfcr_mainpage->setDescription(\_AM_EWFC_REFER_MENU_DSC);
$form->addElement($wfcr_mainpage, false);
/**
 * Submit buttons
 */
$form->addElement(new \XoopsFormButtonTray('submit', _SUBMIT));
$form->endTab();

// ------------------------ EMAIL ----------------------------------------
/**
 * Email Elements
 */
$form->startTab('Email', 'email-info');
/**
 * Refer Main Page item
 */
$wfcr_email = new \XoopsFormRadioYN(\_AM_EWFC_REFER_EMAIL, 'wfcr_email', $this->getVar('wfcr_email'), ' ' . \_AM_WFP_YES, ' ' . \_AM_WFP_NO);
$wfcr_email->setDescription(\_AM_EWFC_REFER_EMAIL_DSC);
$form->addElement($wfcr_email, false);

/**
 * Refer Main Page item
 */
$wfcr_dblurb = new \XoopsFormTextArea(\_AM_EWFC_REFER_DEFBLURB, 'wfcr_dblurb', $this->getVar('wfcr_dblurb'), 15, 70);
$wfcr_dblurb->setDescription(\_AM_EWFC_REFER_DEFBLURB_DSC);
$form->addElement($wfcr_dblurb, false);

/**
 * Refer Main Page item
 */
$wfcr_ublurb = new \XoopsFormRadioYN(\_AM_EWFC_REFER_USERBLURB, 'wfcr_ublurb', $this->getVar('wfcr_ublurb'), ' ' . \_AM_WFP_YES, ' ' . \_AM_WFP_NO);
$wfcr_ublurb->setDescription(\_AM_EWFC_REFER_USERBLURB_DSC);
$form->addElement($wfcr_ublurb, false);

/**
 * Submit buttons
 */
$form->addElement(new \XoopsFormButtonTray('submit', _SUBMIT));
$form->endTab();

// ------------------------ IMAGE ----------------------------------------
$form->startTab(\_AM_WFC_TABIMAGE, 'main-image');
/**
 * Page Image
 */
$wfcr_image = new Xoopsforms\XoopsFormSelectImage(\_AM_EWFC_PAGE_LOGO, 'wfcr_image', $this->getVar('wfcr_image', 'e'), 'xoops_image', 0, $size = 5);
$wfcr_image->setDescription(\_AM_EWFC_PAGE_LOGO_DSC);
$wfcr_image->setCategory(Wfresource\Utility::getModuleOption('uploaddir'));
$form->addElement($wfcr_image, false);

$image = $this->getImageEdit('wfcr_image');

$wfcr_imgwidth = new \XoopsFormText(\_AM_EWFC_MENU_IMGWIDTH, 'imgwidth', 5, 5, $image['width']);
$wfcr_imgwidth->setDescription(\_AM_EWFC_MENU_IMGWIDTH_DSC);
$form->addElement($wfcr_imgwidth, false);

$wfcr_imgheight = new \XoopsFormText(\_AM_EWFC_MENU_IMGHEIGHT, 'imgheight', 5, 5, $image['height']);
$wfcr_imgheight->setDescription(\_AM_EWFC_MENU_IMGHEIGHT_DSC);
$form->addElement($wfcr_imgheight, false);

$wfcr_caption = new \XoopsFormText(\_AM_EWFC_MENU_CAPTION, 'wfcr_caption', 50, 150, $this->getVar('wfcr_caption', 'e'));
$wfcr_caption->setDescription(\_AM_EWFC_MENU_CAPTION_DSC);
$form->addElement($wfcr_caption, false);

$form->addElement(new \XoopsFormButtonTray('submit', _SUBMIT));
$form->endTab();

// ------------------------ PRIVACY ----------------------------------------

/**
 * Permissions Elements
 */
$form->startTab('Privacy', 'privacy-info');

$wfcr_privacy = new \XoopsFormRadioYN(\_AM_EWFC_REFER_PDISPLAY, 'wfcr_privacy', $this->getVar('wfcr_privacy'), ' ' . \_AM_WFP_YES, ' ' . \_AM_WFP_NO);
$wfcr_privacy->setDescription(\_AM_EWFC_REFER_PDISPLAY_DSC);
$form->addElement($wfcr_privacy, false);

$wfcr_privacytext = new \XoopsFormTextArea(\_AM_EWFC_REFER_PSTATEMENT, 'wfcr_privacytext', $this->getVar('wfcr_privacytext', 'e'), 5, 60);
$wfcr_privacytext->setDescription(\_AM_EWFC_REFER_PSTATEMENT_DSC);
$form->addElement($wfcr_privacytext, false);
/**
 * Submit buttons
 */
$form->addElement(new \XoopsFormButtonTray('submit', _SUBMIT));
$form->endTab();

// ------------------------ PERMISSIONS ----------------------------------------

/**
 * Permissions Elements
 */
$form->startTab('Permissions', 'permission-info');

$group = new Wfresource\Permissions(); //wfp_getClass('permissions');
$group->setPermissions('wfcrefer', 'refer_read', '', $GLOBALS['xoopsModule']->getVar('mid'));
$groups = new Xoopsforms\XoopsFormSelectCheckGroup(\_AM_EWFP_GROUPS, 'refer_read', $group->getAdmin($this->getVar('wfcr_id')), '', true);
$groups->setDescription(\_AM_EWFP_GROUPS_DSC);
$form->addElement($groups);
/**
 * Submit buttons
 */
$form->addElement(new \XoopsFormButtonTray('submit', _SUBMIT));
$form->endTab();

// ------------------------ END ----------------------------------------

/**
 * display
 */
$form->display();
