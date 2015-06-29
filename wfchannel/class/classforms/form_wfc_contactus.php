<?php
require_once XOOPS_ROOT_PATH . '/modules/wfresource/class/xoopsformloader.php';

$form = new XoopsThemeForm( _MA_AD_CMODIFYCONTUS, 'op', 'contactus.php' );
$form->setExtra( 'enctype="multipart/form-data"' );
$form->addElement( new XoopsFormText( _MA_AD_CHANQ, 'wfcc_titlecont', 50, 255, $this->getVar( 'wfcc_titlecont', 'e' ) ), true );
$form->insertBreak( _MA_AD_MENU, 'head' );

$form->addElement( $mainpage_radio = new XoopsFormRadioYN( _MA_AD_MAINPAGEITEM, 'wfcc_mainpage', $this->getVar( 'wfcc_mainpage' ), ' ' . _MA_AD_YES . '', ' ' . _MA_AD_NO . '' ) );
$create_tray = new XoopsFormElementTray( '', '' );
$form->addElement( new xoopsFormHidden( 'op', 'save' ) );
$form->addElement( new xoopsFormHidden( 'wfcc_id', $this->getVar( 'wfcc_id' ) ) );
$form->addElement( new XoopsFormButtontray( 'submit', _SUBMIT ) );
$form->display();

?>