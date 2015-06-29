<?php
// $Id: class.refer.php 10055 2012-08-11 12:46:10Z beckmi $
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

define('SALT_LENGTH', 9 );

class wfc_Refer extends wfp_Object {
	/**
	 * XoopsWfPage::XoopsWfPage()
	 */
	function wfc_Refer() {
		$this->XoopsObject();

		$this->initVar( 'wfcr_id', XOBJ_DTYPE_INT, null, false );
		$this->initVar( 'wfcr_title', XOBJ_DTYPE_TXTBOX, '', true, 60 );
		$this->initVar( 'wfcr_content', XOBJ_DTYPE_TXTAREA, '', false );
		$this->initVar( 'wfcr_mainpage', XOBJ_DTYPE_INT, 1, false );
		$this->initVar( 'wfcr_image', XOBJ_DTYPE_TXTBOX, null, true, 250 );
		$this->initVar( 'wfcr_email', XOBJ_DTYPE_INT, null, false );
		$this->initVar( 'wfsr_ublurb', XOBJ_DTYPE_INT, null, false );
		$this->initVar( 'wfcr_dblurb', XOBJ_DTYPE_TXTAREA, null, false );
		$this->initVar( 'wfcr_privacy', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfcr_emailcheck', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfcr_privacytext', XOBJ_DTYPE_TXTAREA, 0, false );
		$this->initVar( 'wfcr_counter', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfcr_caption', XOBJ_DTYPE_TXTBOX, null, false, 255 );
		/**
		 */
		$this->initVar( 'dohtml', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'doxcode', XOBJ_DTYPE_INT, 1, false );
		$this->initVar( 'dosmiley', XOBJ_DTYPE_INT, 1, false );
		$this->initVar( 'doimage', XOBJ_DTYPE_INT, 1, false );
		$this->initVar( 'dobr', XOBJ_DTYPE_INT, 0, false );
	}

	/**
	 * wfc_Refer::doForm()
	 *
	 * @return
	 */
	function doForm() {
		global $xoopsTpl, $refer_handler;

		$_SESSION['wfchannel'][session_id()]['salt'] = $refer_handler->generateHash( $_SERVER['REMOTE_ADDR'] . session_id() );
		/**
		 */
		require_once XOOPS_ROOT_PATH . '/modules/wfresource/class/xoopsformloader.php';
		$form = new XoopsThemeForm( '', 'refer_form', 'index.php', 'post', true );
		$form->setExtra( 'enctype="multipart/form-data"' );
		$form->addElement( new XoopsFormText( _MD_WFC_SENDERNAME, 'uname', 40, 255, $this->getVar( 'uname' ) ), true );
		$form->addElement( new XoopsFormText( _MD_WFC_SENDEREMAIL, 'email', 40, 255, $this->getVar( 'emailaddy' ) ), true );
		$form->addElement( new XoopsFormText( _MD_WFC_RECPINAME, 'runame', 40, 255 ), true );
		$form->addElement( new XoopsFormText( _MD_WFC_RECPIEMAIL, 'remail', 40, 255 ), true );
		if ( $this->getVar( 'wfsr_ublurb' ) ) {
			$form->addElement( new XoopsFormTextArea( _MD_WFC_CAPTACHA, 'message', $this->getVar( 'wfcr_dblurb' ) ), true );
		} else {
			$form->addElement( new XoopsFormHidden( 'message', $this->getVar( 'wfcr_dblurb' ) ) );
		}
		$form->addElement( new XoopsFormCaptcha( _MD_WFC_RECPIEMAIL, 'wfc_captcha', false ), true );
		$form->addElement( new XoopsFormHidden( 'ipsalt', $_SESSION['wfchannel'][session_id()]['salt'] ) );
		$form->addElement( new XoopsFormHidden( 'op', 'refersend' ) );
		$form->addElement( new XoopsFormButtontray( 'submit', _SUBMIT ) );
		$form->assign( $xoopsTpl );
	}
}

/**
 * WfchannelReferHandler
 *
 * @package
 * @author John
 * @copyright Copyright (c) 2007
 * @version $Id: class.refer.php 10055 2012-08-11 12:46:10Z beckmi $
 * @access public
 */
class wfc_ReferHandler extends wfp_ObjectHandler {
	/**
	 * WfchannelPageHandler::XoopsCategoryHandler()
	 *
	 * @param mixed $db
	 * @return
	 */
	function wfc_ReferHandler( &$db ) {
		$this->wfp_ObjectHandler( $db, 'wfcrefer', 'wfc_Refer', 'wfcr_id', 'wfcr_title', 'refer_read' );
	}

	/**
	 * wfc_ReferHandler::generateHash()
	 *
	 * @param mixed $plainText
	 * @param mixed $salt
	 * @return
	 */
	function generateHash( $plainText, $salt = null ) {
		if ( $salt === null ) {
			$salt = substr( md5( uniqid( rand(), true ) ), 0, SALT_LENGTH );
		} else {
			$salt = substr( $salt, 0, SALT_LENGTH );
		}
		return $salt . sha1( $salt . $plainText );
	}

	/**
	 * wfc_ReferHandler::doBanned()
	 *
	 * @return
	 */
	function doBanned() {
		$bannedip = explode( '|', wfp_getModuleOption( 'banned' ) );
		if ( count( $bannedip ) > 0 ) {
			$refers_handler = &wfp_gethandler( 'refers', _MODULE_DIR, _MODULE_CLASS );
			$ip = $refers_handler->getIP();
			if ( in_array( $ip, $bannedip ) ) {
				$xoopsOption['template_main'] = 'wfchannel_banned.html';
				include_once( XOOPS_ROOT_PATH . '/header.php' );
				include_once( XOOPS_ROOT_PATH . '/footer.php' );
				exit();
			}
		}
	}

	/**
	 * wfc_ReferHandler::refersend()
	 *
	 * @return
	 */
	function refersend() {
		global $xoopsConfig, $xoopsUser, $refer_handler;

		$uname = wfp_Request::doRequest( $_REQUEST, 'uname', '', 'textbox' );
		$runame = wfp_Request::doRequest( $_REQUEST, 'runame', '', 'textbox' );
		$message = wfp_Request::doRequest( $_REQUEST, 'message', '', 'textbox' );

		$remail = wfp_Request::doValidate( $_REQUEST['remail'], 'email' );
		$email = wfp_Request::doValidate( $_REQUEST['email'], 'email' );

		if ( false === $remail || false === $email ) {
			return _MD_WFC_EMAILERROR_TEXT;
		}

		include_once XOOPS_ROOT_PATH . '/class/xoopsmailer.php';
		$xoopsMailer = &xoops_getMailer();
		$xoopsMailer->useMail();
		$xoopsMailer->setTemplateDir( XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar( 'dirname' ) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/mail_template' );
		$xoopsMailer->setTemplate( 'refer.tpl' );
		$xoopsMailer->assign( 'SITENAME', $GLOBALS['xoopsConfig']['sitename'] );
		$xoopsMailer->assign( 'SITEURL', XOOPS_URL . '/' );
		$xoopsMailer->assign( 'TITLE', _MD_WFC_MESSAGETITLE );
		$xoopsMailer->assign( 'SUSER', wfp_stripslashes( $uname ) );
		$xoopsMailer->assign( 'RUSER', wfp_stripslashes( $runame ) );
		$xoopsMailer->assign( 'MESSAGE', htmlspecialchars( wfp_stripslashes( $message ) ) );
		$xoopsMailer->assign( 'VISIT', _MD_WFC_VISIT );
		$xoopsMailer->setToEmails( wfp_stripslashes( $remail ) );
		$xoopsMailer->setFromEmail( wfp_stripslashes( $email ) );
		$xoopsMailer->setFromName( wfp_stripslashes( $uname ) );
		$xoopsMailer->setSubject( wfp_stripslashes( $uname ) . ' ' . _MD_WFC_MESSAGESUBECT );
		if ( false == $xoopsMailer->send() ) {
			return _MD_WFC_EMAILSENTWITHERRORS;
		} else {
			$refers_handler = &wfp_gethandler( 'refers', _MODULE_DIR, _MODULE_CLASS );
			$refers_handler->setEmailSendCount();
			$refer_obj = $refers_handler->create();
			$refer_obj->setVar( 'wfcr_username', $uname );
			if ( is_object( $GLOBALS['xoopsUser'] ) ) {
				$refer_obj->setVar( 'wfcr_uid', $GLOBALS['xoopsUser']->getVar( 'uid' ) );
			}
			$refer_obj->setVar( 'wfcr_referurl', $_SERVER['HTTP_REFERER'] );
			$refer_obj->setVar( 'wfcr_ip', $refers_handler->getIP() );
			$refer_obj->setVar( 'wfcr_date', time() );
			$refers_handler->insert( $refer_obj, false );
			redirect_header( 'index.php', 1, _MD_WFC_EMAILSENT );
		}
	}

	/**
	 * wfc_ReferHandler::displayErrors()
	 *
	 * @return
	 */
	function displayErrors() {
		include_once XOOPS_ROOT_PATH . '/header.php';
		$ret = '<h3>' . _MD_WFC_ERRORS . '</h3>';
		$argues = func_get_args();
		if ( func_num_args() == 1 ) {
			$ret .= $argues['0'];
		}
		$ret .= '<div style="padding-top: 12px;"><a href=\'javascript:history.go(-1)\'>[ ' . _MD_WFC_GOBACKBUTTON . ' ]</a></div>';
		echo $ret;
		include XOOPS_ROOT_PATH . '/footer.php';
		exit();
	}
}

?>