# phpMyAdmin SQL Dump
# version 2.11.0
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Dec 21, 2007 at 04:32 AM
# Server version: 5.0.45
# PHP Version: 5.2.4

#
# Table structure for table `wfclink`
#

CREATE TABLE `wfclink` (
  `wfcl_id` tinyint(1) unsigned NOT NULL default '1',
  `wfcl_submenu` tinyint(1) unsigned NOT NULL default '1',
  `wfcl_textlink` varchar(255) NOT NULL,
  `wfcl_linkpagelogo` varchar(255) NOT NULL,
  `wfcl_button` varchar(255) NOT NULL,
  `wfcl_logo` varchar(255) NOT NULL,
  `wfcl_banner` varchar(255) NOT NULL,
  `wfcl_microbutton` varchar(255) NOT NULL,
  `wfcl_mainpage` tinyint(1) unsigned NOT NULL default '1',
  `wfcl_newsfeed` tinyint(1) unsigned NOT NULL default '0',
  `wfcl_texthtml` varchar(255) NOT NULL,
  `wfcl_titlelink` varchar(255) NOT NULL,
  `wfcl_newsfeedjs` tinyint(10) unsigned NOT NULL default '0',
  `wfcl_newstitle` varchar(255) NOT NULL,
  `wfcl_linkintro` text NOT NULL,
  `dohtml` tinyint(1) unsigned NOT NULL default '0',
  `dosmiley` tinyint(1) unsigned NOT NULL default '1',
  `doxcode` tinyint(1) unsigned NOT NULL default '1',
  `doimage` tinyint(1) unsigned NOT NULL default '1',
  `dobr` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`wfcl_id`),
  KEY `wfcl_textlink` (`wfcl_textlink`),
  KEY `wfcl_mainpage` (`wfcl_mainpage`)
) ENGINE=MyISAM;

#
# Dumping data for table `wfclink`
#

INSERT INTO `wfclink` (`wfcl_id`, `wfcl_submenu`, `wfcl_textlink`, `wfcl_linkpagelogo`, `wfcl_button`, `wfcl_logo`, `wfcl_banner`, `wfcl_microbutton`, `wfcl_mainpage`, `wfcl_newsfeed`, `wfcl_texthtml`, `wfcl_titlelink`, `wfcl_newsfeedjs`, `wfcl_newstitle`, `wfcl_linkintro`, `dohtml`, `dosmiley`, `doxcode`, `doimage`, `dobr`) VALUES
(1, 1, 'Change Me', 'linktous.png|300|53', 'poweredby.gif|102|47', 'logo.gif|148|80', 'banner.gif|300|60', 'microbutton.gif|80|15', 1, 1, '', 'Link to us', 1, 'Xoops WF-Channel Feed', 'We welcome you to link to our Web site.  Feel free to create links from any section of your Web site to our articles about your website.  You are also welcome to link to our website directories and other resource pages.\r\n\r\nWhenever possible, we ask that you include our logo with the link on your Web site.  You may use any of the logos below.  Please make the logo a clickable link to the home page of our site, or another appropriate page if you are linking to a specific article or resource.\r\n\r\nTo get a copy of the logo file, simply right-click on the logo of your choice below, and select ''Save Picture as...'' from the pop-up menu to save the image to your hard drive.  Then post the logo to the appropriate page on your site.', 0, 1, 1, 0, 1);

# ############################

#
# Table structure for table `wfcpages`
#

CREATE TABLE `wfcpages` (
  `wfc_cid` mediumint(8) unsigned NOT NULL auto_increment,
  `wfc_title` varchar(255) NOT NULL default '0',
  `wfc_headline` varchar(255) NOT NULL default '0',
  `wfc_content` text NOT NULL,
  `wfc_weight` smallint(5) unsigned NOT NULL default '1',
  `wfc_default` tinyint(1) unsigned NOT NULL default '0',
  `wfc_image` varchar(255) default NULL,
  `wfc_file` varchar(255) default NULL,
  `wfc_usefiletitle` tinyint(1) unsigned NOT NULL default '0',
  `wfc_mainmenu` smallint(1) unsigned NOT NULL default '0',
  `wfc_submenu` tinyint(1) unsigned NOT NULL default '0',
  `wfc_created` int(11) unsigned NOT NULL default '0',
  `wfc_publish` int(11) unsigned NOT NULL default '0',
  `wfc_expired` int(11) unsigned NOT NULL default '0',
  `wfc_counter` mediumint(8) unsigned NOT NULL default '0',
  `wfc_comments` tinyint(1) unsigned NOT NULL default '0',
  `wfc_allowcomments` tinyint(1) unsigned NOT NULL default '0',
  `wfc_search` text NOT NULL,
  `wfc_uid` int(8) unsigned NOT NULL default '0',
  `dohtml` tinyint(1) unsigned NOT NULL default '0',
  `doxcode` tinyint(1) unsigned NOT NULL default '1',
  `dosmiley` tinyint(1) unsigned NOT NULL default '1',
  `doimage` tinyint(1) NOT NULL default '1',
  `dobr` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`wfc_cid`),
  KEY `wfc_title` (`wfc_title`),
  KEY `wfc_publish` (`wfc_publish`),
  KEY `wfc_expired` (`wfc_expired`),
  KEY `wfc_default` (`wfc_default`)
) ENGINE=MyISAM;

#
# Dumping data for table `wfcpages`
#


# ############################

#
# Table structure for table `wfcrefer`
#

CREATE TABLE `wfcrefer` (
  `wfcr_id` tinyint(1) unsigned NOT NULL default '1',
  `wfcr_title` varchar(60) NOT NULL,
  `wfcr_content` text NOT NULL,
  `wfcr_mainpage` smallint(1) unsigned NOT NULL default '0',
  `wfcr_image` varchar(255) NOT NULL,
  `wfcr_email` tinyint(1) unsigned NOT NULL default '1',
  `wfsr_ublurb` smallint(1) unsigned NOT NULL default '0',
  `wfcr_dblurb` text NOT NULL,
  `wfcr_privacy` smallint(1) unsigned NOT NULL default '1',
  `wfcr_emailcheck` smallint(1) unsigned NOT NULL default '1',
  `wfcr_privacytext` text NOT NULL,
  `wfcr_counter` mediumint(8) unsigned NOT NULL default '0',
  `dohtml` tinyint(1) unsigned NOT NULL default '0',
  `doxcode` tinyint(1) unsigned NOT NULL default '1',
  `dosmiley` tinyint(1) unsigned NOT NULL default '1',
  `doimage` tinyint(1) unsigned NOT NULL default '1',
  `dobr` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`wfcr_id`),
  KEY `wfcr_title` (`wfcr_title`),
  KEY `wfcr_mainpage` (`wfcr_mainpage`)
) ENGINE=MyISAM;

#
# Dumping data for table `wfcrefer`
#

INSERT INTO `wfcrefer` (`wfcr_id`, `wfcr_title`, `wfcr_content`, `wfcr_mainpage`, `wfcr_image`, `wfcr_email`, `wfsr_ublurb`, `wfcr_dblurb`, `wfcr_privacy`, `wfcr_emailcheck`, `wfcr_privacytext`, `wfcr_counter`, `dohtml`, `doxcode`, `dosmiley`, `doimage`, `dobr`) VALUES
(1, 'Refer a friend', 'Let a friend know about us.', 1, 'referfriend.png|300|53', 1, 1, 'Please visit this fantastic website that I have just found.', 1, 1, 'We will not and do not collect, sell, or distribute in any way or form the email addresses gathered through this referral option. The intended recipient(s) will only receive the following message and no one else.', 1, 0, 1, 1, 0, 1);

# ############################

#
# Table structure for table `wfcrefers`
#

CREATE TABLE `wfcrefers` (
  `wfcr_id` mediumint(8) unsigned NOT NULL auto_increment,
  `wfcr_username` varchar(60) NOT NULL,
  `wfcr_uid` mediumint(8) unsigned NOT NULL default '0',
  `wfcr_referurl` varchar(255) NOT NULL,
  `wfcr_date` int(10) unsigned NOT NULL,
  `wfcr_ip` varchar(20) NOT NULL,
  UNIQUE KEY `wfcr_id` (`wfcr_id`)
) ENGINE=MyISAM;

#
# Dumping data for table `wfcrefers`
#

