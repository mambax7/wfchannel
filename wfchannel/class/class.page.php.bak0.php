<?php
/**
 * Name: class.page.php
 * Description:
 *
 * @package : Xoosla Modules
 * @Module : WF-Channel
 * @subpackage :
 * @since : v1.0.0
 * @author John Neill <catzwolf@xoosla.com>
 * @copyright : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license : GNU/LGPL, see docs/license.php
 * @version : $Id: class.page.php.bak0.php 8179 2011-11-07 00:54:10Z beckmi $
 */
defined( 'XOOPS_ROOT_PATH' ) or die( 'Restricted access' );

/**
 * Include resource classes
 */
wfp_getObjectHander();

/**
 * wfc_Page
 *
 * @package
 * @author John
 * @copyright Copyright (c) 2009
 * @version $Id: class.page.php.bak0.php 8179 2011-11-07 00:54:10Z beckmi $
 * @access public
 */
class wfc_Page extends wfp_Object {
	/**
	 * XoopsWfPage::XoopsWfPage()
	 */
	function wfc_Page() {
		$this->XoopsObject();
		$this->initVar( 'wfc_cid', XOBJ_DTYPE_INT, null, false );
		$this->initVar( 'wfc_title', XOBJ_DTYPE_TXTBOX, null, true, 120 );
		$this->initVar( 'wfc_headline', XOBJ_DTYPE_TXTBOX, null, false, 150 );
		$this->initVar( 'wfc_content', XOBJ_DTYPE_TXTAREA, null, false );
		$this->initVar( 'wfc_weight', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfc_default', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfc_image', XOBJ_DTYPE_TXTBOX, null, false, 250 );
		$this->initVar( 'wfc_file', XOBJ_DTYPE_URL, 'http://', false, 250 );
		$this->initVar( 'wfc_usefiletitle', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfc_created', XOBJ_DTYPE_INT, time(), false );
		$this->initVar( 'wfc_publish', XOBJ_DTYPE_INT, null, false );
		$this->initVar( 'wfc_expired', XOBJ_DTYPE_INT, null, false );
		$this->initVar( 'wfc_mainmenu', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfc_submenu', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfc_counter', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfc_comments', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfc_allowcomments', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'wfc_uid', XOBJ_DTYPE_INT, 0, false );
		// **//
		$this->initVar( 'dohtml', XOBJ_DTYPE_INT, 0, false );
		$this->initVar( 'doxcode', XOBJ_DTYPE_INT, 1, false );
		$this->initVar( 'dosmiley', XOBJ_DTYPE_INT, 1, false );
		$this->initVar( 'doimage', XOBJ_DTYPE_INT, 1, false );
		$this->initVar( 'dobr', XOBJ_DTYPE_INT, 1, false );
	}

	/**
	 * wfc_Page::getHtml()
	 *
	 * @return
	 */
	function getHtml() {
		if ( $this->getVar( 'wfc_file' ) == 'http://' OR !$this->getVar( 'wfc_file' ) ) {
			$_maintext = $this->getVar( 'wfc_content', 's' );
		} else {
			if ( preg_match( "/http/", $this->getVar( 'wfc_file' ) ) ) {
				$maintextfile = str_replace( XOOPS_URL, XOOPS_ROOT_PATH, $this->getVar( 'wfc_file' ) );
			} else {
				$maintextfile = XOOPS_ROOT_PATH . '/' . $GLOBALS['xoopsModuleConfig']['htmluploaddir'] . '/' . $this->getVar( 'wfc_file' );
			}
			if ( is_readable( $maintextfile ) ) {
				$_maintext = file_get_contents( $maintextfile );
				$_maintext = trim( $_maintext );
			} else {
				$_maintext = _MD_WFC_FILEERROR;
			}
		}
		$_maintext = preg_replace( '|<\s*img\s?src=[\"\'](?!/)(.*?)[\"\']\s*(.*?)\s*>|is', "<img src=\"" . XOOPS_URL . "/$1\" $2>", $_maintext );
		return $_maintext;
	}

	/**
	 * wfc_Page::getImage()
	 *
	 * @return
	 */
	function getImage() {
		if ( $this->getVar( 'wfc_image' ) != 'blank.png' || $this->getVar( 'wfc_image' ) != 'blank.gif' ) {
			$image = explode( '|', $this->getVar( 'wfc_image' ) );
			$image = ( is_array( $image ) ) ? $image[0] : $this->getVar( 'wfc_image' );
			return $image;
		} else {
			return '';
		}
	}

	/**
	 * wfc_Page::getTitle()
	 *
	 * @return
	 */
	function getTitle() {
		if ( $GLOBALS['xoopsModuleConfig']['displaypagetitle'] ) {
			return $this->getVar( 'wfc_headline' );
		} else {
			return '';
		}
	}
}

/**
 * wfc_PageHandler
 *
 * @package
 * @author John
 * @copyright Copyright (c) 2007
 * @version $Id: class.page.php.bak0.php 8179 2011-11-07 00:54:10Z beckmi $
 * @access public
 */
class wfc_PageHandler extends wfp_ObjectHandler {
	/**
	 * wfc_PageHandler::XoopsCategoryHandler()
	 *
	 * @param mixed $db
	 * @return
	 */
	function wfc_PageHandler( &$db ) {
		$this->wfp_ObjectHandler( $db, 'wfcpages', 'wfc_Page', 'wfc_cid', 'wfc_title', 'wfc_page' );
	}

	/**
	 * wfc_PageHandler::getList()
	 *
	 * @return
	 */
	function &getList() {
		$criteria = new CriteriaCompo();
		$criteria->add( new Criteria( 'wfc_mainmenu', 1, '=' ) );
		$criteria->add( new Criteria( 'wfc_publish', 0, '>' ), 'AND' );
		$criteria->add( new Criteria( 'wfc_publish', time(), '<=' ), 'AND' );
		$criteria->add( new Criteria( 'wfc_expired', 0, '=' ), 'AND' );
		$criteria->add( new Criteria( 'wfc_expired', time(), '>' ), 'OR' );
		$criteria->setSort( 'wfc_weight' );
		$criteria->setOrder( 'ASC' );
		$ret = &$this->getObjects( $criteria );
		return $ret;
	}

	/**
	 * wfc_PageHandler::getDefaultPage()
	 *
	 * @return
	 */
	function &getDefaultPage() {
		$ret = '';
		//if ( empty( $_SESSION['wfchanneldefault'] ) ) {
			$obj = $this->get( 0, true, 'wfc_default' );
			if ( is_object( $obj ) ) {
				$ret['id'] = $_SESSION['wfchanneldefault']['id'] = $obj->getVar( 'wfc_cid' );
				$ret['title'] = $_SESSION['wfchanneldefault']['title'] = $obj->getVar( 'wfc_title' );
			}
		//	else {
		//		unset( $_SESSION['wfchanneldefault'] );
		//	}
		//	unset( $obj );
		//} else {
		//	$ret['id'] = $_SESSION['wfchanneldefault']['id'];
		//	$ret['title'] = $_SESSION['wfchanneldefault']['title'];
		//}
		return $ret;
	}

	/**
	 * wfc_PageHandler::getObj()
	 *
	 * @param array $nav
	 * @param mixed $value
	 * @return
	 */
	function &getObj() {
		$obj = false;
		if ( func_num_args() == 2 ) {
			$args = func_get_args();
			$criteria = new CriteriaCompo();
			$obj['count'] = $this->getCount( $criteria );
			if ( !empty( $args[0] ) ) {
				$criteria->setSort( $args[0]['sort'] );
				$criteria->setOrder( $args[0]['order'] );
				$criteria->setStart( $args[0]['start'] );
				$criteria->setLimit( $args[0]['limit'] );
			}
			$obj['list'] = &$this->getObjects( $criteria, $args[1] );
		}
		return $obj;
	}

	/**
	 * wfc_PageHandler::getChanlinks()
	 *
	 * @return
	 */
	function &getChanlinks() {
		$wfpages_obj = &$this->getList();
		$cid = wfp_cleanRequestVars( $_REQUEST, 'cid', 0 );
		$op = wfp_cleanRequestVars( $_REQUEST, 'op', '', XOBJ_DTYPE_TXTBOX );

		if ( $cid == 0 AND !$op ) {
			$css = "style='text-decoration: underline;'";
			$doneCss = true;
		} else {
			$css = "style='text-decoration: none;'";
		}

		$wfpages['chanlink'][] = array( 'css' => $css, 'id' => '', 'title' => 'Home' );
		$doneCss = false;
		foreach ( array_keys( $wfpages_obj ) as $i ) {
			if ( $wfpages_obj[$i]->getVar( 'wfc_cid' ) == $cid ) {
				$css = "style='text-decoration: underline;'";
				$doneCss = true;
			} else {
				$css = "style='text-decoration: none;'";
			}
			$wfpages['chanlink'][] = array( 'css' => $css, 'id' => '?cid=' . $wfpages_obj[$i]->getVar( 'wfc_cid' ), 'title' => $wfpages_obj[$i]->getVar( 'wfc_title' ) );
		}
		unset( $wfpages_obj );

		if ( $op == 'link' ) {
			$css = "style='text-decoration: underline;'";
			$doneCss = true;
		} else {
			$css = "style='text-decoration: none;'";
		}
		if ( !isset( $_SESSION['wfc_channel']['wfcl_titlelink'] ) ) {
			$links_handler = &wfp_gethandler( 'link', _MODULE_DIR, _MODULE_CLASS );
			$links = $links_handler->get( 1 );
			if ( $links ) {
				$_SESSION['wfc_channel']['wfcl_titlelink'] = $links->getVar( 'wfcl_titlelink' );
				if ( is_object( $links ) && $links->getVar( 'wfcl_mainpage' ) ) {
					$wfpages['chanlink'][] = array( 'css' => $css, 'id' => '?op=link', 'title' => $links->getVar( 'wfcl_titlelink' ) );
				}
			}
		} else {
			if ( isset( $_SESSION['wfc_channel']['wfcl_titlelink'] ) ) {
				$wfpages['chanlink'][] = array( 'css' => $css, 'id' => '?op=link', 'title' => $_SESSION['wfc_channel']['wfcl_titlelink'] );
			}
		}

		if ( $op == 'refer' ) {
			$css = "style='text-decoration: underline;'";
			$doneCss = true;
		} else {
			$css = "style='text-decoration: none;'";
		}
		if ( !isset( $_SESSION['wfc_channel']['wfcr_title'] ) ) {
			$refer_handler = &wfp_gethandler( 'refer', _MODULE_DIR, _MODULE_CLASS );
			$refer = $refer_handler->get( 1 );
			if ( $refer ) {
				$_SESSION['wfc_channel']['wfcr_title'] = $refer->getVar( 'wfcr_title' );
				if ( is_object( $refer ) && $refer->getVar( 'wfcr_mainpage' ) ) {
					$wfpages['chanlink'][] = array( 'css' => $css, 'id' => '?op=refer', 'title' => $refer->getVar( 'wfcr_title' ) );
				}
			}
		} else {
			if ( isset( $_SESSION['wfc_channel']['wfcr_title'] ) ) {
				$wfpages['chanlink'][] = array( 'css' => $css, 'id' => '?op=refer', 'title' => $_SESSION['wfc_channel']['wfcr_title'] );
			}
		}

		if ( $op == 'cont' ) {
			$css = "style='text-decoration: underline;'";
			$doneCss = true;
		} else {
			$css = "style='text-decoration: none;'";
		}
		// if ( !isset( $_SESSION['wfc_channel']['wfcc_titlecont'] ) ) {
		// $contact_handler = &wfp_gethandler( 'contactus', _MODULE_DIR, _MODULE_CLASS );
		// $contactus = $contact_handler->get( 1 );
		// if ( $contactus ) {
		// $_SESSION['wfc_channel']['wfcc_titlecont'] = $contactus->getVar( 'wfcc_titlecont' );
		// if ( is_object( $contactus ) && $contactus->getVar( 'wfcr_mainpage' ) ) {
		// $wfpages['chanlink'][] = array( 'css' => $css, 'id' => '?op=refer', 'title' => $contactus->getVar( 'wfcc_titlecont' ) );
		// }
		// }
		// } else {
		// if ( isset( $_SESSION['wfc_channel']['wfcc_titlecont'] ) ) {
		// $wfpages['chanlink'][] = array( 'css' => $css, 'id' => '?op=contact', 'title' => $_SESSION['wfc_channel']['wfcc_titlecont'] );
		// }
		// }
		return $wfpages;
	}

	/**
	 * wfc_PageHandler::update()
	 *
	 * @return
	 */
	function update( &$obj ) {
		// this adds 30 days to the current time
		setcookie( 'wfcChannelpage', date( 'D Y-M' ), time() + 120 );
		if ( isset( $_COOKIE['wfcChannelpage'] ) ) {
			// $last = $_COOKIE['wfcChannelpage'];
			// echo "Welcome back! You last visited on " . $last;
		} else {
			$criteria = new CriteriaCompo();
			$criteria->add( new Criteria( 'wfc_cid', $obj->getVar( 'wfc_cid' ) ) );
			$this->updateCounter( 'wfc_counter', $criteria );
		}
	}

	/**
	 * wfc_PageHandler::updateDefaultPage()
	 *
	 * @return
	 */
#	function updateDefaultPage( $doFull = false ) {
#		if ( $doFull ) {
#			$this->updateAll( 'wfc_default', 0 );
#		}
#		unset( $_SESSION['wfchanneldefault'] );
#	}

	/**
	 * wfc_PageHandler::getHtml()
	 *
	 * @param string $file
	 * @param string $cleanlevel
	 * @return
	 */
	function &getHtml( $file = '', $cleanlevel = '' ) {
		if ( preg_match( "/http/", $file ) ) {
			$maintextfile = str_replace( XOOPS_URL, XOOPS_ROOT_PATH, $file );
		} else {
			$maintextfile = XOOPS_ROOT_PATH . '/' . $GLOBALS['xoopsModuleConfig']['htmluploaddir'] . '/' . $file;
		}
		if ( is_readable( $maintextfile ) ) {
			$_maintext = file_get_contents( $maintextfile );
			$_maintext = trim( $_maintext );
		} else {
			return false;
		}
		$_maintext = preg_replace( '|<\s*img\s?src=[\"\'](?!/)(.*?)[\"\']\s*(.*?)\s*>|is', "<img src=\"/$1\" $2>", $_maintext );
		if ( preg_match( '_<title>(.*)</title>_is', $_maintext, $tmp ) ) {
			$maintext['title'] = $tmp[0];
			unset( $tmp );
		}
		if ( preg_match( '_<body>(.*)</body>_is', $_maintext, $tmp ) ) {
			$maintext['body'] = stristr( $tmp[0], "<body" );
		} else {
			$maintext['body'] = $_maintext;
		}
		return $maintext;
	}

	/**
	 * wfc_PageHandler::cleanUpHTML()
	 *
	 * @param mixed $text
	 * @param mixed $cleanlevel
	 * @return
	 */
	function &cleanUpHTML( $text, $cleanlevel ) {
		// remove escape slashes
		$text = stripslashes( $text );
		// trim everything before the body tag right away, leaving possibility for body attributes
		if ( preg_match( '_<body>(.*)</body>_is', $text, $tmp ) ) {
			$text = stristr( $tmp[0], "<body" );
		}
		// strip tags, still leaving attributes, second variable is allowable tags
		switch ( $cleanlevel ) {
			case 1:
				$text = strip_tags( $text, '<p><b><i><u><a><h1><h2><h3><h4><h4><h5><h6>' );
				// removes the attributes for allowed tags, use separate replace for heading tags since a
				// heading tag is two characters
				$text = ereg_replace( "<([p|b|i|u])[^>]*>", "<\\1>", $text );
				$text = ereg_replace( "<([h1|h2|h3|h4|h5|h6][1-6])[^>]*>", "<\\1>", $text );
				break;
			case 2:
				$text = strip_tags( $text, '<br />' );
				break;
			default:
		} // switch
		return ( $text );
	}

	/**
	 * wfc_PageHandler::getMainContent()
	 *
	 * @param mixed $_page_obj
	 * @param mixed $ret
	 * @return
	 */
	function getMainContent( &$_page_obj, $ret ) {
		$ts = &MyTextSanitizer::getInstance();
		$html = !$_page_obj->getVar( 'dohtml' ) ? 1 : 0;
		$xcode = ( !$_page_obj->getVar( 'doxcode' ) || $this->vars['doxcode']['value'] == 1 ) ? 1 : 0;
		$smiley = $_page_obj->getVar( 'dosmiley' ); //( !isset( $this->vars['dosmiley']['value'] ) || $this->vars['dosmiley']['value'] == 1 ) ? 1 : 0;
		$image = $_page_obj->getVar( 'doimage' ); //( !isset( $this->vars['doimage']['value'] ) || $this->vars['doimage']['value'] == 1 ) ? 1 : 0;
		$br = $_page_obj->getVar( 'dobr' ); //( !isset( $this->vars['dobr']['value'] ) || $this->vars['dobr']['value'] == 1 ) ? 1 : 0;
		$text = $ts->displayTarea( $ret, $html, $smiley, $xcode, $image, $br );
		return $text;
	}

	/**
	 * wfc_PageHandler::setSearch()
	 *
	 * @param mixed $headline
	 * @param mixed $maintext
	 * @return
	 */
	function &setSearch( $headline, $maintext ) {
		$search = htmlspecialchars( $headline . " " . $maintext );
		$tmpvar = xoops_trim( $search );
		$search = $myts->displayTarea( $tmpvar, 1, 1, 1, 1, 1 );
		$search = xoops_trim( $search );
		// dernier retraitement des tags html
		$ascii_array = array_merge( array( 34, 38, 60, 62 ), range( 160, 255 ) );
		$chars_array = array_map( "chr", $ascii_array );
		$html_array = array_map( "htmlentities", $chars_array );
		// Remplace les codes html par leurs équivalents txt dans le texte
		for( $i = 0; $i < count( $ascii_array ); $i++ ) {
			$search = ereg_replace( $html_array[$i], $chars_array[$i], $search );
		}
		$search = ereg_replace( "<br />", " ", $search );
		// elimine des faux positifs
		$search = ereg_replace( "-//W3C//DTD HTML 4.0 Transitional//EN", " ", $search );
		$search = ereg_replace( "name=AUTHOR", " ", $search );
		$search = ereg_replace( "name=COPYRIGHT", " ", $search );
		$search = ereg_replace( "name=DESCRIPTION", " ", $search );
		$search = ereg_replace( "name=GENERATOR", " ", $search );
		$search = ereg_replace( "border=0", " ", $search );
		$search = ereg_replace( "'", " ", $search );
		$search = strip_tags( $search );
		return $search;
	}

	/**
	 * wfc_PageHandler::getSearch()
	 *
	 * @param mixed $queryarray
	 * @param mixed $andor
	 * @param mixed $limit
	 * @param mixed $offset
	 * @return
	 */

	function &getSearch( $queryarray, $andor, $limit, $offset ) {
		$criteria = new CriteriaCompo();
		if ( $andor != 'exact' ) {
			$andor = $andor;
		} else {
			$andor = '';
		}
		if ( is_array( $queryarray ) && $count = count( $queryarray ) ) {
			$criteria->add( new Criteria( "wfc_title", "%$queryarray[0]%", 'LIKE' ), 'OR' );
			$criteria->add( new Criteria( "wfc_headline", "%$queryarray[0]%", 'LIKE' ), 'OR' );
			$criteria->add( new Criteria( "wfc_content", "%$queryarray[0]%", 'LIKE' ), 'OR' );
			if ( !empty( $andor ) ) {
				for( $i = 1;$i < $count;$i++ ) {
					$criteria->add( new Criteria( "wfc_title", "%$queryarray[$i]%", 'LIKE' ), 'OR' );
					$criteria->add( new Criteria( "wfc_headline", "%$queryarray[$i]%", 'LIKE' ), 'OR' );
					$criteria->add( new Criteria( "wfc_content", "%$queryarray[$i]%", 'LIKE' ), 'OR' );
				}
			}
		}
		$criteria->setSort( 'wfc_publish' );
		$criteria->setOrder( 'ASC' );
		$criteria->setStart( @$offset );
		$criteria->setLimit( @$limit );
		$obj['list'] = &$this->getObjects( $criteria, false );
		return $obj;
	}

	/**
	 * wfc_PageHandler::headingHtml()
	 *
	 * @return
	 */
	function headingHtml( $total_count ) {
		/**
		 * bad bad bad!! Need to change this
		 */
		global $list_array, $nav;
		/**
		 */
		$refers_handler = &wfp_gethandler( 'refers', 'wfchannel', 'wfc_' );
		$refer_count = $refers_handler->getEmailSentCount();
		$default = self::getDefaultPage();

		$ret = "<div style='padding-bottom: 8px;'>";
		if ( $default == null ) {
			$ret .= _MA_WFC_NODEFAULTPAGESET;
		} else {
			$ret .= _MA_WFC_DEFAULTPAGESET . ": <a href='../index.php?op=edit&wfc_cid=" . $default['id'] . "'>" . $default['title'] . "</a>";
		}
		$ret .= "<div>" . _MA_WFC_TOTALNUMCHANL . ": <b>" . $total_count . "</b></div>";
		$ret .= "<div>" . _MA_WFC_TOTALEMAILSSENT . ": <b>" . $refer_count . "</b></div>";
		if ( $refer_count > 0 ) {
			$ret .= '<a href="' . XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar( 'dirname' ) . '/admin/refers.php">' . _MA_WFC_VIEW . '</a><br />';
		}
		$ret .= "</div>";
		$ret .= '<form><div style="text-align: left; margin-bottom: 12px;"><input type="button" name="button" onclick=\'location="index.php?op=edit"\' value="' . _MA_WFP_CREATENEW . '"></div></form>';
		$ret .= "<div style='text-align: right'>" . _MA_WFP_DISPLAYAMOUNT_BOX . wfp_getSelection( $list_array, $nav['limit'], "limit", 1, 0, false, false, "onchange=\"location='index.php?limit='+this.options[this.selectedIndex].value\"" , 0, false ) . "</div>";
		echo $ret;
		unset( $refer_handler );
	}

	/**
	 * wfc_PageHandler::getAction()
	 *
	 * @param mixed $obj
	 * @param mixed $act
	 * @return
	 */
	function getAction( &$obj, $act ) {
		$pdf_data['filename'] = str_replace( ' ', '_', ( strtolower( $obj->getVar( 'wfc_title' ) ) ) );
		$pdf_data['path'] = XOOPS_ROOT_PATH . '/cache/' . md5( $obj->getVar( 'wfc_cid' ) );
		$pdf_data['creator'] = $GLOBALS['xoopsConfig']['sitename']; //"Xoops";
		$pdf_data['title'] = $obj->getVar( 'wfc_title' );
		$pdf_data['subtitle'] = $obj->getVar( 'wfc_headline' );
		$pdf_data['subsubtitle'] = '';
		$pdf_data['renderdate'] = $obj->formatTimeStamp( 'today' );
		$pdf_data['pdate'] = $obj->formatTimeStamp( 'wfc_publish' );
		$pdf_data['slogan'] = $GLOBALS['xoopsConfig']['sitename'] . ' - ' . $GLOBALS['xoopsConfig']['slogan'];
		$content = $obj->getHtml();
		$pdf_data['sitename'] = $GLOBALS['xoopsConfig']["sitename"];
		$pdf_data['itemurl'] = XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar( 'dirname' ) . '/index.php?index.php?cid=' . $obj->getVar( 'wfc_cid' );
		$pdf_data['stdoutput'] = 'file';
		/**
		 * do switch
		 */
		switch ( $act ) {
			case 'print':
				$content = str_replace( '[pagebreak]', "\n\n", $content );
				$pdf_data['content'] = $content;
				wfp_doPrint( $pdf_data );
				break;
			case 'dopdf':
				$content = str_replace( '[pagebreak]', "\n\n", $this->pdfCleaner( $content ) );
				$pdf_data['content'] = $content;
				wfp_doPdf( $pdf_data );
				break;
		} // switch
		exit();
	}

	/**
	 * wfc_PageHandler::decodeHTML()
	 *
	 * @param mixed $string
	 * @return
	 */
	function decodeHTML( $string ) {
		$string = strtr( $string, array_flip( get_html_translation_table( HTML_ENTITIES ) ) );
		$string = preg_replace( "/&#([0-9]+);/me", "chr('\\1')", $string );
		return $string;
	}

	/**
	 * wfc_PageHandler::pdfCleaner()
	 *
	 * @param mixed $text
	 * @return
	 */
	function pdfCleaner( $text ) {
		$text = str_replace( '<p>', "\n\n", $text );
		$text = str_replace( '<P>', "\n\n", $text );
		$text = str_replace( '<br />', "\n", $text );
		$text = str_replace( '<br>', "\n", $text );
		$text = str_replace( '<BR />', "\n", $text );
		$text = str_replace( '<BR>', "\n", $text );
		$text = str_replace( '<li>', "\n - ", $text );
		$text = str_replace( '<LI>', "\n - ", $text );
		$text = str_replace( '[pagebreak]', '', $text );
		$text = strip_tags( $text );
		$text = $this->decodeHTML( $text );
		return $text;
	}

	/**
	 * wfc_PageHandler::getPageNumber()
	 *
	 * @return
	 */
	function getPageNumber() {
		$ret = 0;
		if ( isset( $_REQUEST['wfc_cid'] ) ) {
			$ret = wfp_cleanRequestVars( $_REQUEST, 'wfc_cid', 0 );
		} elseif ( isset( $_REQUEST['cid'] ) ) {
			$ret = wfp_cleanRequestVars( $_REQUEST, 'cid', 0 );
		} elseif ( isset( $_REQUEST['pagenum'] ) ) {
			$ret = wfp_cleanRequestVars( $_REQUEST, 'pagenum', 0 );
		}
		return ( int )$ret;
	}
}

?>