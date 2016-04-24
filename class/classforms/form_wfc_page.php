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

if (!$this->isNew()) {
    echo '<div style="padding: 5px; float: left;"><a target="_BLANK" href="../index.php?wfc_cid=' . $this->getVar('wfc_cid') . '">' . _AM_WFC_QUICKVIEW . '</a></div>';
}

/**
 */
$form = new XoopsThemeTabForm((!$this->isNew()) ? sprintf(_AM_WFP_MODIFY, $this->getVar('wfc_title')) : _AM_WFP_CREATE, 'page_form', 'index.php');
$form->setExtra('enctype="multipart/form-data"');
$form->doTabs();
/**
 * Hidden Values
 */
$form->addElement(new XoopsFormHiddenToken());
$form->addElement(new xoopsFormHidden('op', 'save'));
$form->addElement(new xoopsFormHidden('wfc_cid', $this->getVar('wfc_cid')));

/**
 * First Fields
 */
$form->startTab(_AM_WFC_TABMAIN, 'main-info');
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
 */
$options = array(
    'name'   => 'wfc_content',
    'value'  => $this->getVar('wfc_content', 'e'),
    'rows'   => 35,
    'cols'   => 75,
    'width'  => '100%',
    'height' => '400px'
);

$options_tray = new XoopsFormElementTray(_AM_EWFC_PAGE_CONTENT . ': ' . $this->getVar('wfc_title'), '<br />');
//$options_tray->setNocolspan(1);

$wfc_content = new XoopsFormEditor('', wfp_getModuleOption('use_wysiwyg'), $options, $nohtml = false, $onfailure = 'textarea');
$options_tray->addElement($wfc_content);
// $options_tray->setDescription( _AM_EWFC_TEXTCONTENT_DSC );

if (wfp_isEditorHTML()) {
    $options_tray->addElement(new xoopsFormHidden('dohtml', 1));
    $options_tray->addElement(new xoopsFormHidden('dobr', 0));
} else {
    if ($this->isNew()) {
        $this->setVar('dohtml', 0);
        $this->setVar('dobr', 1);
    }
    $html_checkbox = new XoopsFormCheckBox('', 'dohtml', $this->getVar('dohtml'));
    $html_checkbox->addOption(1, _AM_EWFP_DOHTML);
    $options_tray->addElement($html_checkbox);
    $breaks_checkbox = new XoopsFormCheckBox('', 'dobr', $this->getVar('dobr'));
    $breaks_checkbox->addOption(1, _AM_EWFP_BREAKS);
    $options_tray->addElement($breaks_checkbox);
}

/**
 */
$xcodes_checkbox = new XoopsFormCheckBox('', 'doxcode', $this->getVar('doxcode', 'e'));
$xcodes_checkbox->addOption(1, _AM_EWFP_DOXCODE);
$options_tray->addElement($xcodes_checkbox);
/**
 */
$smiley_checkbox = new XoopsFormCheckBox('', 'dosmiley', $this->getVar('dosmiley', 'e'));
$smiley_checkbox->addOption(1, _AM_EWFP_DOSMILEY);
$options_tray->addElement($smiley_checkbox);
$form->addElement($options_tray);

/**
 * HTML File Options
 */
$options_tray2 = new XoopsFormElementTray(_AM_EWFC_PAGE_WRAP, '<br /><br />');
$options_tray2->setDescription(_AM_EWFC_PAGE_WRAP_DSC);
$htmlfile_select = new XoopsFormText('', 'wfc_file', 50, 150, $this->getVar('wfc_file', 'e'));
$options_tray2->addElement($htmlfile_select, false);

$wfc_usefiletitle = new XoopsFormRadioYN(_AM_EWFC_USEFTITLE, 'wfc_usefiletitle', $this->getVar('wfc_usefiletitle', 'e'), ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
$options_tray2->addElement($wfc_usefiletitle);

$wfc_doimport = new XoopsFormRadioYN(_AM_EWFC_DOIMPORT, 'wfc_doimport', 0, ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
$options_tray2->addElement($wfc_doimport);
$form->addElement($options_tray2);

$clean_select = new XoopsFormSelect(_AM_EWFC_CLEANINGOPTIONS, 'wfc_cleaningoptions', 0);
$clean_select->setDescription(_AM_EWFC_CLEANINGOPTIONS_DSC);
$clean_select->addOption(0, _AM_EWFC_CLEANRAW);
$clean_select->addOption(1, _AM_EWFC_CLEANHTML);
$clean_select->addOption(2, _AM_EWFC_CLEANMSWORD);
$clean_select->addOption(3, _AM_EWFC_CLEANALL);
$form->addElement($clean_select);

/**
 * Buttons
 */
$form->addElement(new XoopsFormButtontray('submit', _SUBMIT));
$form->endTab();

/**
 * Others
 */
$form->startTab(_AM_WFC_TABPUBLISH, 'main-published');

$page_uid = new XoopsFormSelectUser(_AM_EWFC_MENU_AUTHOR, 'wfc_uid', true, $this->getUserID('wfc_uid'), 1, false);
$page_uid->setDescription(_AM_EWFC_MENU_AUTHOR_DSC);
$form->addElement($page_uid, true);

$page_author = new XoopsFormText(_AM_EWFC_MENU_AUTHORALIAS, 'wfc_author', 50, 60, $this->getVar('wfc_author', 'e'));
$page_author->setDescription(_AM_EWFC_MENU_AUTHORALIAS_DSC);
$form->addElement($page_author, false);
/**
 * weight
 */
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
 * Set Page State
 */
$state_select = new XoopsFormSelect(_AM_WFC_SELSTATUS, 'wfc_active', $this->getVar('wfc_active'));
$state_select->setDescription(_AM_WFC_SELSTATUS_DSC);
$state_select->addOption(1, _AM_WFC_SELPUBLISHED);
$state_select->addOption(2, _AM_WFC_SELUNPUBLISHED);
$state_select->addOption(3, _AM_WFC_SELEXPIRED);
$state_select->addOption(0, _AM_WFC_SELOFFLINE);
$form->addElement($state_select);

/**
 */
$wfc_default = new XoopsFormRadioYN(_AM_EWFC_DEFAULT, 'wfc_default', $this->getVar('wfc_default', 'e'), ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
$wfc_default->setDescription(_AM_EWFC_DEFAULT_DSC);
$form->addElement($wfc_default);

/**
 * This is for the Channel links
 */
if (!$this->getVar('wfc_default')) {
    $wfc_mainmenu = new XoopsFormRadioYN(_AM_EWFC_MAINMENU, 'wfc_mainmenu', $this->getVar('wfc_mainmenu', 'e'), ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
    $wfc_mainmenu->setDescription(_AM_EWFC_MAINMENU_DSC);
    $form->addElement($wfc_mainmenu);
}

/**
 * This is for the Xoops style manu
 */
$wfc_submenu = new XoopsFormRadioYN(_AM_EWFC_SUBMENU, 'wfc_submenu', $this->getVar('wfc_submenu', 'e'), ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
$wfc_submenu->setDescription(_AM_EWFC_SUBMENU_DSC);
$form->addElement($wfc_submenu);

/**
 * Allow Comments
 */
$wfc_allowcomments = new XoopsFormRadioYN(_AM_EWFC_ALLOWCOMMENTS, 'wfc_allowcomments', $this->getVar('wfc_allowcomments', 'e'), ' ' . _AM_WFP_YES . '', ' ' . _AM_WFP_NO . '');
$wfc_allowcomments->setDescription(_AM_EWFC_ALLOWCOMMENTS_DSC);
$form->addElement($wfc_allowcomments);

/**
 * Buttons
 */
$form->addElement(new XoopsFormButtontray('submit', _SUBMIT));
$form->endTab();

$form->startTab(_AM_WFC_TABIMAGE, 'main-image');
/**
 * Page Image
 */
$page_image = new XoopsFormSelectImage(_AM_EWFC_PAGE_LOGO, 'wfc_image', $this->getVar('wfc_image', 'e'), 'xoops_image', 0, $size = 5);
$page_image->setDescription(_AM_EWFC_PAGE_LOGO_DSC);
$page_image->setCategory($GLOBALS['xoopsModuleConfig']['uploaddir']);
$form->addElement($page_image, false);

$image = $this->getImageEdit('wfc_image');

$page_imgwidth = new XoopsFormText(_AM_EWFC_MENU_IMGWIDTH, 'imgwidth', 5, 5, $image['width']);
$page_imgwidth->setDescription(_AM_EWFC_MENU_IMGWIDTH_DSC);
$form->addElement($page_imgwidth, false);

$page_imgheight = new XoopsFormText(_AM_EWFC_MENU_IMGHEIGHT, 'imgheight', 5, 5, $image['height']);
$page_imgheight->setDescription(_AM_EWFC_MENU_IMGHEIGHT_DSC);
$form->addElement($page_imgheight, false);

$page_caption = new XoopsFormText(_AM_EWFC_MENU_CAPTION, 'wfc_caption', 50, 150, $this->getVar('wfc_caption', 'e'));
$page_caption->setDescription(_AM_EWFC_MENU_CAPTION_DSC);
$form->addElement($page_caption, false);

$form->addElement(new XoopsFormButtontray('submit', _SUBMIT));
$form->endTab();

$form->startTab(_AM_WFC_TABMETA, 'main-meta');
/**
 * Meta tags title
 */
$wfc_metakeywords = new XoopsFormTextArea(_AM_EWFC_METATITLE, 'wfc_metakeywords', $this->getVar('wfc_metakeywords', 'e'), $rows = 5, $cols = 50);
$wfc_metakeywords->setDescription(_AM_EWFC_METATITLE_DSC);
$wfc_metakeywords->setNocolspan(0);
$form->addElement($wfc_metakeywords);
/**
 * Meta tags title
 */
$category_meta = new XoopsFormTextArea(_AM_EWFC_MDESCRIPTION, 'wfc_metadescription', $this->getVar('wfc_metadescription', 'e'), $rows = 5, $cols = 50);
$category_meta->setDescription(_AM_EWFC_MDESCRIPTION_DSC);
$category_meta->setNocolspan(0);
$form->addElement($category_meta);

/**
 */
$wfc_related = new XoopsFormText(_AM_EWFC_MENU_RELATED, 'wfc_related', 50, 255, $this->getVar('wfc_related', 'e'));
$wfc_related->setDescription(_AM_EWFC_MENU_RELATED_DSC);
$form->addElement($wfc_related, false);

/**
 */
if (wfp_tag_module_included()) {
    require_once XOOPS_ROOT_PATH . '/modules/tag/include/formtag.php';
    $item_tag = new XoopsFormTag('item_tag', 60, 255, $this->getVar('wfc_cid'), 0);
    $item_tag->setDescription(_AM_EWFC_METATITLE_DSC);
    $form->addElement($item_tag);
}

$form->addElement(new XoopsFormButtontray('submit', _SUBMIT));
$form->endTab();

/**
 * Permissions
 */
$form->startTab(_AM_WFC_TABPERMISSIONS, 'main-permissions');
$group = &wfp_getClass('permissions');
$group->setPermissions('wfcpages', 'page_read', '', $GLOBALS['xoopsModule']->getVar('mid'));
$groups = new XoopsFormSelectCheckGroup(_AM_EWFP_GROUPS, 'page_read', $group->getAdmin($this->getVar('wfc_cid')), '', true);
$groups->setDescription(_AM_EWFP_GROUPS_DSC);
$form->addElement($groups);

/**
 * Buttons
 */
$form->addElement(new XoopsFormButtontray('submit', _SUBMIT));
$form->endTab();

if (!$this->isNew()) {
    $handler = &wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
    $ret     = '<br /><div><b>' . _AM_WFC_QUICKLINK . '</b> ' . _AM_WFC_COPYSTANDALONE . '</div>';
    $ret .= '<div style="padding: 5px;">' . XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/index.php?cid=' . $this->getVar('wfc_cid') . '</div><br />';
    $ret .= $handler->pageInfo($this);

    $form->startTab(_AM_WFC_INFO, 'main-information');
    $page_info = new XoopsFormLabel(_AM_EWFC_MENU_INFO, $ret);
    $page_info->setDescription(_AM_EWFC_MENU_INFO_DSC);
    //    $page_info->setNocolspan(1);
    $form->addElement($page_info, false);

    $form->addElement(new XoopsFormButtontray('submit', _SUBMIT));
    $form->endTab();
}
$form->display();
