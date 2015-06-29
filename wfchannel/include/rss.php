<?php
/**
 * Name: rss.php
 * Description:
 *
 * @package : Xoosla Modules
 * @Module :
 * @subpackage :
 * @since : v1.0.0
 * @author John Neill <catzwolf@xoosla.com>
 * @copyright : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license : GNU/LGPL, see docs/license.php
 * @version : $Id: rss.php 8179 2011-11-07 00:54:10Z beckmi $
 */
defined( 'XOOPS_ROOT_PATH' ) or die( 'Restricted access' );

$GLOBALS['xoopsLogger']->activated = false;
if ( function_exists( 'mb_http_output' ) ) {
	mb_http_output( 'pass' );
}

include_once XOOPS_ROOT_PATH . '/class/template.php';
$tpl = new XoopsTpl();
$tpl->xoops_setCaching( 0 );
$tpl->xoops_setCacheTime( 3600 );
if ( !$tpl->is_cached( 'db:system_rss.html', 'wfc|feed|rss' ) ) {
	xoops_load( 'XoopsLocal' );
	$rssContent = wfp_getClass( 'rss' );
	$rssContent->basics( 'wfchannel_slogo.png', 'modules/' . $GLOBALS['xoopsModule']->getVar( 'dirname' ) . '/images' );
	$rss = $rssContent->render();
	foreach( $rss as $key => $value ) {
		$tpl->assign( $key, $value );
	}

	$handler = &wfp_gethandler( 'page', _MODULE_DIR, _MODULE_CLASS );
	$objects = $handler->getList( 'wfc_publish', 'DESC', 0, 30 );
	if ( count( $objects ) > 0 ) {
		// Get users for items
		// Assign items to template
		$url = XOOPS_URL . '/modules/wfchannel/';
		foreach( $objects as $obj ) {
			$link = $url . 'index.php?cid=' . $obj->getVar( 'wfc_cid' );
			$tpl->append( 'items', array( 'title' => xoops_utf8_encode( $obj->getVar( 'wfc_headline', 'e' ) ),
					'author' => xoops_utf8_encode( $obj->getUserName( 'wfc_uid' ) ),
					'link' => $link,
					'guid' => $link,
					'is_permalink' => false,
					'pubdate' => $obj->getTimeStamp( 'wfc_publish', 'rss' ),
					'dc_date' => $obj->getTimeStamp( 'wfc_publish', 'd/m H:i' ),
					'description' => xoops_utf8_encode( xoops_substr( $obj->getVar( 'wfc_content', 's' ), 0, 150, '...' ) ),
					) );
		}
	}
}

header ( 'Content-Type:text/xml; charset=utf-8' );
$tpl->display( 'db:system_rss.html', 'wfc|feed|rss' );

?>