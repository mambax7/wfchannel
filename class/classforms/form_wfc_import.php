<?php
/**
 * Name: form_wfc_page.php
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
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 */
$form = new XoopsThemeForm((!$this->isNew()) ? sprintf(_AM_WFP_MODIFY, $this->getVar('wfc_title')) : _AM_WFP_CREATE, 'page_form', 'index.php');
$form->setExtra('enctype="multipart/form-data"');
/**
 * Hidden Values
 */
$form->addElement(new XoopsFormHiddenToken());
$form->addElement(new xoopsFormHidden('op', 'save'));

/**
 * Page Title
 */
$page_title = new XoopsFormText(_AM_EWFC_MENU_TITLE, 'wfc_title', 50, 150, $this->getVar('wfc_title', 'e'));
$page_title->setDescription(_AM_EWFC_MENU_TITLE_DSC);
$form->addElement($page_title, true);
/**
 * Page Headline
 */
$page_subtitle = new XoopsFormText(_AM_EWFC_PAGE_TITLE, 'wfc_headline', 50, 150, $this->getVar('wfc_headline', 'e'));
$page_subtitle->setDescription(_AM_EWFC_PAGE_TITLE_DSC);
$form->addElement($page_subtitle, false);
/**
 * Page Image
 */
$page_image = new XoopsFormSelectImage(_AM_EWFC_PAGE_LOGO, 'wfc_image', $this->getVar('wfc_image', 'e'), 'xoops_image', 0, $size = 5);
$page_image->setDescription(_AM_EWFC_PAGE_LOGO_DSC);
$page_image->setCategory($GLOBALS['xoopsModuleConfig']['uploaddir']);
$form->addElement($page_image, false);

$clean_select = new XoopsFormSelect(_AM_EWFC_CLEANINGOPTIONS, 'wfc_cleaningoptions', 0);
$clean_select->setDescription(_AM_EWFC_CLEANINGOPTIONS_DSC);
$clean_select->addOption(0, _AM_EWFC_CLEANRAW);
$clean_select->addOption(1, _AM_EWFC_CLEANHTML);
$clean_select->addOption(2, _AM_EWFC_CLEANMSWORD);
$clean_select->addOption(3, _AM_EWFC_CLEANALL);
$form->addElement($clean_select);

/**
 * Others
 */
$form->startTab('Published', 'main-published');
$page_weight = new XoopsFormText(_AM_EWFC_WEIGHT, 'wfc_weight', 5, 5, $this->getVar('wfc_weight', 'e'));
$page_weight->setDescription(_AM_EWFC_WEIGHT_DSC);
$form->addElement($page_weight, false);
/**
 */
$wfc_publish = new XoopsFormTextDateSelect(_AM_EWFC_PUBLISH, 'wfc_publish', 20, $this->getVar('wfc_publish', 'e'), $this->isNew());
$wfc_publish->setDescription(_AM_EWFC_PUBLISH_DSC);
$form->addElement($wfc_publish);
/**
 */
$wfc_expired = new XoopsFormTextDateSelect(_AM_EWFC_EXPIRE, 'wfc_expired', 0, $this->getVar('wfc_expired', 'e'), false);
$wfc_expired->setDescription(_AM_EWFC_EXPIRE_DSC);
$form->addElement($wfc_expired);
/**
 */
$wfc_default = new XoopsFormRadioYN(_AM_EWFC_DEFAULT, 'wfc_default', $this->getVar('wfc_default', 'e'), ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
$wfc_default->setDescription(_AM_EWFC_DEFAULT_DSC);
$form->addElement($wfc_default);
/**
 * if item is Default
 */
if (!$this->getVar('wfc_default')) {
    $wfc_mainmenu = new XoopsFormRadioYN(_AM_EWFC_MAINMENU, 'wfc_mainmenu', $this->getVar('wfc_mainmenu', 'e'), ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
    $wfc_mainmenu->setDescription(_AM_EWFC_MAINMENU_DSC);
    $form->addElement($wfc_mainmenu);
}

$wfc_submenu = new XoopsFormRadioYN(_AM_EWFC_SUBMENU, 'wfc_submenu', $this->getVar('wfc_submenu', 'e'), ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
$wfc_submenu->setDescription(_AM_EWFC_SUBMENU_DSC);
$form->addElement($wfc_submenu);

/**
 * Buttons
 */
$form->addElement(new XoopsFormButtontray('submit', _SUBMIT));
