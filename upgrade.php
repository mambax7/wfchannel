<?php
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
defined('XOOPS_ROOT_PATH') || exit('You do not have permission to access this file!');
include __DIR__ . '/header.php';
$op = wfp_cleanRequestVars($_REQUEST, 'op', 'default', XOBJ_DTYPE_TXTBOX);
switch ($op) {
    case 'upgrade':
        include XOOPS_ROOT_PATH . '/header.php';
        echo '<p><b>' . _MD_WFC_UPDATE24 . "</b></p>\n";
        echo "<br><p><b>Updating table wfcpages</b></p>\n";
        $updater = wfp_getClass('updater');
        $result  = $updater->RenameTable('wfschannel', 'wfcpages');
        if (!$result) {
            $updater->getError();
            $updater->render();
            include XOOPS_ROOT_PATH . '/footer.php';
            exit();
        }

        $updater->setTable('wfcpages');
        $updater->changeField('CID', ' wfc_cid tinyint( 1 ) unsigned NOT null default "0"');
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
        $updater->changeField('html', 'dohtml tinyint( 1 ) unsigned NOT null default "0"', 'wfc_search');
        $updater->changeField('xcodes', 'doxcode tinyint( 1 ) unsigned NOT null default "1"', 'html');
        $updater->changeField('smiley', 'dosmiley tinyint( 1 ) unsigned NOT null default "1"', 'xcodes');
        $updater->changeField('breaks', 'dobr tinyint( 1 ) unsigned NOT null default "1"', 'smiley');
        $updater->addField('dobr', 'tinyint( 1 ) NOT null default "1" ', 'dosmiley');
        $updater->addField('doimage', 'tinyint( 1 ) NOT null default "1" ', 'dohtml');
        $updater->addField('wfc_uid', "int( 8 ) unsigned NOT null default '0'");
        // end change fields
        $updater->doChange();
        displayOutput();
        // Updating table wfclink
        echo "<br><p><b>Updating table wfcrefer</b></p>\n";
        $updater = wfp_getClass('updater');
        $updater->setTable('wfcrefer');
        $result = $updater->RenameTable('wfsrefer', 'wfcrefer');
        if (!$result) {
            $updater->getError();
            $updater->render();
            include XOOPS_ROOT_PATH . '/footer.php';
            exit();
        }

        $updater->changeField('titlerefer', '`wfcr_title` varchar(60) NOT NULL');
        $updater->changeField('chanrefheadline', '`wfcr_content` text NOT NULL');
        $updater->changeField('submenuitem', "`wfcr_submenuitem` smallint(1) unsigned NOT NULL default '0'");
        $updater->changeField('mainpage', "`wfcr_mainpage` smallint(1) unsigned NOT NULL default '0'");
        $updater->changeField('referpagelogo', '`wfcr_image` varchar(255) NOT NULL');
        $updater->changeField('emailaddress', "`wfcr_email` tinyint(1) unsigned NOT NULL default '1'");
        $updater->changeField('usersblurb', "`wfsr_ublurb` smallint(1) unsigned NOT NULL default '0'");
        $updater->changeField('defblurb', '`wfcr_dblurb` text NOT NULL');
        $updater->changeField('smiley', "`dosmiley` tinyint(1) unsigned NOT NULL default '1'");
        $updater->changeField('xcodes', "`doxcode` tinyint(1) unsigned NOT NULL default '1'");
        $updater->changeField('breaks', "`dobr` tinyint(1) unsigned NOT NULL default '1'");
        $updater->changeField('html', "`dohtml` tinyint(1) unsigned NOT NULL default '0'");
        $updater->changeField('privacy', "`wfcr_privacy` smallint(1) unsigned NOT NULL default '1'");
        $updater->changeField('emailcheck', "`wfcr_emailcheck` smallint(1) unsigned NOT NULL default '1'");
        $updater->changeField('privacy_statement', '`wfcr_privacytext` text NOT NULL');
        $updater->addField('wfcr_id', "tinyint(1) unsigned NOT NULL default '1'");
        $updater->addField('doimage', 'tinyint( 1 ) NOT null default "1" ', 'dosmiley');
        $updater->addField('wfcr_counter', 'mediumint(8) unsigned NOT NULL default "0"', 'wfcr_privacytext');

        $updater->doChange();
        displayOutput();
        // Updating table wfcrefer
        echo "<br><p><b>Updating table wfclink</b></p>\n";
        $updater = wfp_getClass('updater');
        $updater->setTable('wfclink');
        $result = $updater->RenameTable('wfslinktous', 'wfclink');
        if (!$result) {
            $updater->getError();
            $updater->render();
            include XOOPS_ROOT_PATH . '/footer.php';
            exit();
        }
        $updater->changeField('submenuitem', "`wfcl_submenu` tinyint(1) unsigned NOT NULL default '1'");
        $updater->changeField('textlink', '`wfcl_textlink` varchar( 255 ) NOT null');
        $updater->changeField('linkpagelogo', '`wfcl_linkpagelogo` varchar( 255 ) NOT null');
        $updater->changeField('button', '`wfcl_button` varchar( 255 ) NOT null');
        $updater->changeField('logo', '`wfcl_logo` varchar( 255 ) NOT null');
        $updater->changeField('banner', '`wfcl_banner` varchar( 255 ) NOT null');
        $updater->changeField('mainpage', "`wfcl_mainpage` tinyint( 1 ) unsigned NOT null default '1'");
        $updater->changeField('newsfeed', "`wfcl_newsfeed` tinyint( 1 ) unsigned NOT null default '0'");
        $updater->changeField('texthtml', '`wfcl_texthtml` varchar(255) NOT NULL');
        $updater->changeField('titlelink', '`wfcl_titlelink` varchar( 255 ) NOT null');
        $updater->changeField('newsfeedjs', "`wfcl_newsfeedjs` tinyint( 10 ) unsigned NOT null default '0'");
        $updater->changeField('linkintro', '`wfcl_linkintro` text NOT null');
        $updater->changeField('newstitle', '`wfcl_newstitle` varchar( 255 ) NOT null');
        $updater->addField('wfcl_microbutton', 'varchar(255) NOT NULL');
        $updater->addField('wfcl_id', "tinyint(1) unsigned NOT NULL default '1'");
        $updater->addField('dohtml', "tinyint( 1 ) unsigned NOT null default '0'");
        $updater->addField('dosmiley', "tinyint( 1 ) unsigned NOT null default '1'");
        $updater->addField('doxcode', "tinyint( 1 ) unsigned NOT null default '1'");
        $updater->addField('doimage', "tinyint( 1 ) unsigned NOT null default '1'");
        $updater->addField('dobr', "tinyint( 1 ) unsigned NOT null default '1'");

        $updater->doChange();
        displayOutput();

        // Updating table wfcrefers;
        echo "<br><p><b>Updating table wfcrefers</b></p>\n";

        $updater = wfp_getClass('updater');
        $data    = "  `wfcr_id` mediumint(8) unsigned NOT NULL auto_increment,
      `wfcr_username` varchar(60) NOT NULL,
      `wfcr_uid` mediumint(8) unsigned NOT NULL default '0',
      `wfcr_referurl` varchar(255) NOT NULL,
      `wfcr_date` int(10) unsigned NOT NULL,
      `wfcr_ip` varchar(20) NOT NULL,
      UNIQUE KEY `wfcr_id` (`wfcr_id`)";

        $result = $updater->createTable('wfcrefers', $data, 1);
        if (!$result) {
            $updater->getError();
            $updater->render();
            include XOOPS_ROOT_PATH . '/footer.php';
            exit();
        }
        displayOutput();
        break;

    case 'intro':
    default:
        include XOOPS_ROOT_PATH . '/header.php';
        echo "<table align=\"center\" width='100 % ' border='0'><tr><td align='center'><b>" . _MD_WFC_UPDATE1 . '</b></td></tr><tr><td>&nbsp;</td></tr></table>';
        echo "<table align=\"center\" width='50 % ' border='0'><tr><td colspan='2'>"
             . _MD_WFC_UPDATE2
             . '<br><br><b>'
             . _MD_WFC_UPDATE3
             . '<b></td></tr><tr><td></td><td >'
             . _MD_WFC_UPDATE4
             . "</td></tr><tr><td></td><td><span style='color:// ff0000;font-weight:bold;'>"
             . _MD_WFC_UPDATE5
             . '</span></td></tr></table>';
        echo '<p>' . _MD_WFC_UPDATE6 . '</p>';
        echo "<form action='" . xoops_getenv('PHP_SELF') . "' method='post'>";
        echo $GLOBALS['xoopsSecurity']->getTokenHTML();
        echo "<input type='submit' value='Start Upgrade'><input type='hidden' name='op' value='upgrade'></form>";
        break;
} // switch
include XOOPS_ROOT_PATH . '/footer.php';

function displayOutput()
{
    global $updater;

    echo '<h4>' . _MD_WFC_SUCCESS . '</h4>';
    $_success = $updater->getSuccess();
    if (count($_success)) {
        foreach ($_success as $success) {
            echo "<div style=\"text-indent: 12px;\">$success</div>";
        }
    } else {
        echo "<div style=\"text-indent: 12px;\">" . sprintf(_MD_WFC_NOTHING_UPDATED, $updater->getTable()) . '</div>';
    }

    echo '<h4>' . _MD_WFC_FAILURE . '</h4>';
    $_errors = $updater->getError();
    if (count($_errors)) {
        foreach ($_errors as $errors) {
            echo "<div style=\"text-indent: 12px;\">$errors</div>";
        }
    } else {
        echo "<div style=\"text-indent: 12px;\">" . sprintf(_MD_WFC_NO_ERRORSFOUND, $updater->getTable()) . '</div>';
    }
}
