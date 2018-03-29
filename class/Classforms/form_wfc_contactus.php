<?php
require_once XOOPS_ROOT_PATH . '/modules/wfresource/class/xoopsformloader.php';

$form = new \XoopsThemeForm(_AM_AD_CMODIFYCONTUS, 'op', 'contactus.php');
$form->setExtra('enctype="multipart/form-data"');
$form->addElement(new \XoopsFormText(_AM_AD_CHANQ, 'wfcc_titlecont', 50, 255, $this->getVar('wfcc_titlecont', 'e')), true);
$form->insertBreak(_AM_AD_MENU, 'head');

$form->addElement($mainpage_radio = new \XoopsFormRadioYN(_AM_AD_MAINPAGEITEM, 'wfcc_mainpage', $this->getVar('wfcc_mainpage'), ' ' . _AM_AD_YES . '', ' ' . _AM_AD_NO . ''));
$create_tray = new \XoopsFormElementTray('', '');
$form->addElement(new xoopsFormHidden('op', 'save'));
$form->addElement(new xoopsFormHidden('wfcc_id', $this->getVar('wfcc_id')));
$form->addElement(new \XoopsFormButtontray('submit', _SUBMIT));
$form->display();
