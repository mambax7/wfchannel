<?php declare(strict_types=1);
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

use XoopsModules\Wfchannel;
use XoopsModules\Wfresource;

defined('XOOPS_ROOT_PATH') || exit('You do not have permission to access this file!');

global $updater;

if (!defined('_WF_INSTALLER')) {
    exit('Cannot access this updater directly');
    exit();
}
/**
 * Rename old table to new table
 */
$updater = new Wfresource\Updater(); //wfp_getClass('updater');
if ($oldversion < 200) {
    $updater->RenameTable('wfschannel', 'wfcpages');

    /**
     * Update Tables
     */
    $updater->setTable('wfcpages');
    $updater->changeField('CID', 'wfc_cid mediumint(8) unsigned NOT NULL AUTO_INCREMENT');
    $updater->changeField('pagetitle', 'wfc_title varchar( 255 ) NOT null default "0"');
    $updater->changeField('pageheadline', 'wfc_headline varchar( 255 ) NOT null default "0"');
    $updater->changeField('page', 'wfc_content text NOT null');
    $updater->changeField('weight', 'wfc_weight smallint( 5 ) unsigned NOT null default "1"');
    $updater->changeField('defaultpage', 'wfc_default tinyint( 1 ) unsigned NOT null default "0"');
    $updater->changeField('indeximage', 'wfc_image varchar( 255 ) default null');
    $updater->changeField('htmlfile', 'wfc_file varchar( 255 ) default null');
    $updater->changeField('usedoctitle', 'wfc_usefiletitle tinyint( 1 ) unsigned NOT null default "0"');
    $updater->changeField('mainpage', 'wfc_mainmenu smallint( 1 ) unsigned NOT null default "0"');
    $updater->changeField('submenu', 'wfc_submenu tinyint( 1 ) unsigned NOT null default "0"');
    $updater->changeField('created', 'wfc_created int( 11 ) unsigned NOT null default "0"');
    $updater->changeField('publishdate', 'wfc_publish int( 11 ) unsigned NOT null default "0"');
    $updater->changeField('expiredate', 'wfc_expired int( 11 ) unsigned NOT null default "0"');
    $updater->changeField('counter', 'wfc_counter mediumint( 8 ) unsigned NOT null default "0"');
    $updater->changeField('comments', 'wfc_comments tinyint( 1 ) unsigned NOT null default "0"');
    $updater->changeField('allowcomments', 'wfc_allowcomments tinyint( 1 ) unsigned NOT null default "0"');

    $updater->addField('doimage', 'tinyint( 1 ) NOT null default "1" ', 'dosmiley');
    $updater->addField('wfc_uid', "int( 8 ) unsigned NOT null default '0'", 'wfc_counter');

    $updater->addField('wfc_metakeywords', 'text NOT null', 'wfc_uid');
    $updater->addField('wfc_metadescription', 'text NOT null', 'wfc_metakeywords');
    $updater->addField('wfc_related', 'varchar( 255 ) NOT null default ""', 'wfc_metadescription');
    $updater->addField('wfc_author', 'varchar( 255 ) NOT null default ""', 'wfc_related');
    $updater->addField('wfc_caption', 'varchar( 255 ) NOT null default ""', 'wfc_author');
    $updater->addField('wfc_active', 'varchar( 255 ) NOT null default ""', 'wfc_caption');

    $updater->changeField('html', 'dohtml tinyint( 1 ) unsigned NOT null default "0"');
    $updater->changeField('xcodes', 'doxcode tinyint( 1 ) unsigned NOT null default "1"');
    $updater->changeField('smiley', 'dosmiley tinyint( 1 ) unsigned NOT null default "1"');
    $updater->changeField('breaks', 'dobr tinyint( 1 ) unsigned NOT null default "1"');

    $updater->modifyField('dohtml', 'tinyint(1) unsigned NOT NULL default "0"', 'wfc_uid');
    $updater->modifyField('doxcode', 'tinyint(1) unsigned NOT NULL default "1"', 'dohtml');
    $updater->modifyField('dosmiley', 'tinyint(1) unsigned NOT NULL default "1"', 'doxcode');
    $updater->modifyField('doimage', 'tinyint(1) unsigned NOT NULL default "1"', 'dosmiley');
    $updater->modifyField('dobr', 'tinyint(1) unsigned NOT NULL default "1"', 'doimage');

    $updater->dropField('', 'INDEX (topicID)');
    $updater->dropField('', 'INDEX (answer)');
    // end change fields
    $updater->doChange();
}

/**
 * Rename old table to new table
 */
$updater = new Wfresource\Updater(); //wfp_getClass('updater');
if ($oldversion < 200) {
    $updater->RenameTable('wfsrefer', 'wfcrefer');

    /**
     * Update Tables
     */
    $updater->setTable('wfcrefer');
    $updater->changeField('titlerefer', '`wfcr_title` varchar(60) NOT NULL');
    $updater->changeField('chanrefheadline', '`wfcr_content` text NOT NULL');
    $updater->changeField('submenuitem', '`wfcr_submenuitem` smallint(1) unsigned NOT NULL default "0"');
    $updater->changeField('mainpage', '`wfcr_mainpage` smallint(1) unsigned NOT NULL default "0"');
    $updater->changeField('referpagelogo', '`wfcr_image` varchar(255) NOT NULL');
    $updater->changeField('emailaddress', '`wfcr_email` tinyint(1) unsigned NOT NULL default "1"');
    $updater->changeField('usersblurb', '`wfsr_ublurb` smallint(1) unsigned NOT NULL default "0"');
    $updater->changeField('defblurb', '`wfcr_dblurb` text NOT NULL');
    $updater->changeField('smiley', '`dosmiley` tinyint(1) unsigned NOT NULL default "1"');
    $updater->changeField('xcodes', '`doxcode` tinyint(1) unsigned NOT NULL default "1"');
    $updater->changeField('breaks', '`dobr` tinyint(1) unsigned NOT NULL default "1"');
    $updater->changeField('html', '`dohtml` tinyint(1) unsigned NOT NULL default "0"');
    $updater->changeField('privacy', '`wfcr_privacy` smallint(1) unsigned NOT NULL default "1"');
    $updater->changeField('emailcheck', '`wfcr_emailcheck` smallint(1) unsigned NOT NULL default "1"');
    $updater->changeField('privacy_statement', '`wfcr_privacytext` text NOT NULL');
    $updater->changeField('counter', '`wfcr_counter` mediumint(8) unsigned NOT NULL default "0"');

    $updater->addField('wfcr_id', 'tinyint(1) unsigned NOT NULL default "1"', 'FIRST');
    $updater->addField('doimage', 'tinyint( 1 ) NOT null default "1" ', 'dosmiley');
    $updater->addField('wfcr_counter', 'mediumint(8) unsigned NOT NULL default "0"', 'wfcr_privacytext');

    $updater->modifyField('dohtml', 'tinyint(1) unsigned NOT NULL default "0"', 'wfcr_counter');
    $updater->modifyField('doxcode', 'tinyint(1) unsigned NOT NULL default "1"', 'dohtml');
    $updater->modifyField('dosmiley', 'tinyint(1) unsigned NOT NULL default "1"', 'doxcode');
    $updater->modifyField('doimage', 'tinyint(1) unsigned NOT NULL default "1"', 'dosmiley');
    $updater->modifyField('dobr', 'tinyint(1) unsigned NOT NULL default "1"', 'doimage');

    $updater->dropField('', 'INDEX wfcr_submenuitem');
    $updater->dropField('', 'PRIMARY KEY');
    $updater->addField('', 'PRIMARY KEY (wfcr_id)');
    $updater->addField('', 'INDEX wfcr_title (wfcr_title)');
    $updater->addField('', 'INDEX wfcr_mainpage (wfcr_mainpage)');
    $updater->doChange();
}
/**
 * Rename old table to new table
 */
$updater = new Wfresource\Updater(); //wfp_getClass('updater');
if ($oldversion < 200) {
    $updater->RenameTable('wfslinktous', 'wfclink');

    /**
     * Update Tables
     */
    $updater->setTable('wfclink');
    $updater->changeField('submenuitem', '`wfcl_submenu` tinyint(1) unsigned NOT NULL default "1"');
    $updater->changeField('textlink', '`wfcl_textlink` varchar( 255 ) NOT null');
    $updater->changeField('linkpagelogo', '`wfcl_image` varchar( 255 ) NOT null');
    $updater->changeField('button', '`wfcl_button` varchar( 255 ) NOT null');
    $updater->changeField('logo', '`wfcl_logo` varchar( 255 ) NOT null');
    $updater->changeField('banner', '`wfcl_banner` varchar( 255 ) NOT null');
    $updater->changeField('mainpage', '`wfcl_mainpage` tinyint( 1 ) unsigned NOT null default "1"');
    $updater->changeField('newsfeed', '`wfcl_newsfeed` tinyint( 1 ) unsigned NOT null default "0"');
    $updater->changeField('texthtml', '`wfcl_texthtml` varchar(255) NOT NULL');
    $updater->changeField('titlelink', '`wfcl_titlelink` varchar( 255 ) NOT null');
    $updater->changeField('newsfeedjs', '`wfcl_newsfeedjs` tinyint( 10 ) unsigned NOT null default "0"');
    $updater->changeField('linkintro', '`wfcl_content` text NOT null');
    $updater->changeField('newstitle', '`wfcl_newstitle` varchar( 255 ) NOT null');
    $updater->addField('wfcl_microbutton', 'varchar(255) NOT NULL');
    $updater->addField('wfcl_id', "tinyint(1) unsigned NOT NULL default '1'", 'FIRST');
    $updater->addField('dohtml', "tinyint( 1 ) unsigned NOT null default '0'");
    $updater->addField('dosmiley', "tinyint( 1 ) unsigned NOT null default '1'");
    $updater->addField('doxcode', "tinyint( 1 ) unsigned NOT null default '1'");
    $updater->addField('doimage', "tinyint( 1 ) unsigned NOT null default '1'");
    $updater->addField('dobr', "tinyint( 1 ) unsigned NOT null default '1'");

    $updater->dropField('', 'INDEX wfcl_submenu');
    $updater->dropField('', 'PRIMARY KEY');
    $updater->addField('', 'PRIMARY KEY (wfcl_id)');
    $updater->addField('', 'INDEX wfcl_textlink (wfcl_textlink)');
    $updater->addField('', 'INDEX wfcl_mainpage (wfcl_mainpage)');
    $updater->doChange();
}

if ($oldversion < 200) {
    /**
     * Add New Table
     */
    $updater = new Wfresource\Updater(); //wfp_getClass('updater');
    $data    = "  `wfcr_id` mediumint(8) unsigned NOT NULL auto_increment,
      `wfcr_username` varchar(60) NOT NULL,
      `wfcr_uid` mediumint(8) unsigned NOT NULL default '0',
      `wfcr_referurl` varchar(255) NOT NULL,
      `wfcr_date` int(10) unsigned NOT NULL,
      `wfcr_ip` varchar(20) NOT NULL,
      UNIQUE KEY `wfcr_id` (`wfcr_id`)";
    $updater->createTable('wfcrefers', $data, 1);
}

if ($oldversion < 200) {
    /**
     * Lets fix issues with dohtml, dosmilies ect
     */
    $pageHandler = new Wfchannel\PageHandler($db); //wfp_getHandler('page', 'wfchannel', 'wfc_');
    $obj         = $pageHandler->getObj(null, true);
    if ($obj['count'] > 0) {
        foreach ($obj['list'] as $objs) {
            $ret             = [];
            $ret['dohtml']   = (0 == $objs->getVar('dohtml')) ? 1 : 0;
            $ret['dosmiley'] = (0 == $objs->getVar('dohtml')) ? 1 : 0;
            $ret['doxcode']  = (0 == $objs->getVar('dohtml')) ? 1 : 0;
            $ret['dobr']     = (0 == $objs->getVar('dohtml')) ? 1 : 0;
            $new_obj         = $pageHandler->get($objs->getVar('wfc_cid'));
            $new_obj->setVars($ret);
            @$pageHandler->insert($new_obj, false);
        }
    }
}
/**
 * Update Previous update issues if required
 */
if ($oldversion > 200 && $oldversion < 205) {
    /**
     * Pages
     */
    $updater = new Wfresource\Updater(); //wfp_getClass('updater');
    $updater->setTable('wfcpages');
    $updater->changeField('wfc_cid', 'wfc_cid mediumint(8) unsigned NOT NULL AUTO_INCREMENT');
    $updater->addField('wfc_usefiletitle', 'tinyint(1) unsigned NOT NULL DEFAULT "0"', 'wfc_file');

    $updater->modifyField('dohtml', 'tinyint(1) unsigned NOT NULL default "0"', 'wfc_uid');
    $updater->modifyField('doxcode', 'tinyint(1) unsigned NOT NULL default "1"', 'dohtml');
    $updater->modifyField('dosmiley', 'tinyint(1) unsigned NOT NULL default "1"', 'doxcode');
    $updater->modifyField('doimage', 'tinyint(1) unsigned NOT NULL default "1"', 'dosmiley');
    $updater->modifyField('dobr', 'tinyint(1) unsigned NOT NULL default "1"', 'doimage');

    $updater->addField('wfc_metakeywords', 'text NOT null', 'wfc_uid');
    $updater->addField('wfc_metadescription', 'text NOT null', 'wfc_metakeywords');
    $updater->addField('wfc_related', 'varchar( 255 ) NOT null default ""', 'wfc_metadescription');
    $updater->addField('wfc_author', 'varchar( 255 ) NOT null default ""', 'wfc_related');
    $updater->addField('wfc_caption', 'varchar( 255 ) NOT null default ""', 'wfc_author');
    $updater->addField('wfc_active', 'varchar( 255 ) NOT null default ""', 'wfc_caption');

    $updater->dropField('', 'INDEX topicID');

    $updater->dropField('wfc_search');
    $updater->dropField('', 'INDEX answer');
    $updater->addField('', 'INDEX wfc_title (wfc_title)');
    $updater->addField('', 'INDEX wfc_publish (wfc_publish)');
    $updater->addField('', 'INDEX wfc_expired (wfc_expired)');
    $updater->addField('', 'INDEX wfc_default (wfc_default)');
    $updater->doChange();

    /**
     * Links
     */
    $updater = new Wfresource\Updater(); //wfp_getClass('updater');
    $updater->setTable('wfclink');
    $updater->modifyField('wfcl_id', 'tinyint(1) unsigned NOT NULL default "1"', 'FIRST');
    $updater->dropField('', 'wfcl_newsfeedjs');
    $updater->dropField('', 'PRIMARY KEY');
    $updater->addField('', 'PRIMARY KEY (wfcl_id)');
    $updater->addField('', 'INDEX wfcl_textlink (wfcl_textlink)');
    $updater->addField('', 'INDEX wfcl_mainpage (wfcl_mainpage)');
    $updater->changeField('wfcl_linkpagelogo', '`wfcl_image` varchar( 255 ) NOT null');
    $updater->changeField('wfcl_linkintro', '`wfcl_content` varchar( 255 ) NOT null');
    $updater->addField('wfcl_caption', 'varchar( 255 ) NOT null default ""', 'wfcl_content');
    $updater->doChange();

    /**
     * Refer
     */
    $updater = new Wfresource\Updater(); //wfp_getClass('updater');
    $updater->setTable('wfcrefer');
    $updater->modifyField('wfcr_id', 'tinyint(1) unsigned NOT NULL default "1"', 'FIRST');
    $updater->dropField('', 'PRIMARY KEY');
    $updater->addField('', 'PRIMARY KEY (wfcr_id)');
    $updater->addField('', 'INDEX wfcr_title (wfcr_title)');
    $updater->addField('', 'INDEX wfcr_mainpage (wfcr_mainpage)');

    $updater->modifyField('dohtml', 'tinyint(1) unsigned NOT NULL default "0"', 'wfcr_counter');
    $updater->modifyField('doxcode', 'tinyint(1) unsigned NOT NULL default "1"', 'dohtml');
    $updater->modifyField('dosmiley', 'tinyint(1) unsigned NOT NULL default "1"', 'doxcode');
    $updater->modifyField('doimage', 'tinyint(1) unsigned NOT NULL default "1"', 'dosmiley');
    $updater->modifyField('dobr', 'tinyint(1) unsigned NOT NULL default "1"', 'doimage');
    $updater->addField('wfcr_caption', 'varchar( 255 ) NOT null default ""', 'wfcr_counter');
    $updater->doChange();
}
