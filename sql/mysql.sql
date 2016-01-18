#
# Table structure for table `wfclink`
#

CREATE TABLE `wfclink` (
  `wfcl_id` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `wfcl_submenu` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `wfcl_textlink` varchar(255) NOT NULL,
  `wfcl_image` varchar(255) NOT NULL,
  `wfcl_button` varchar(255) NOT NULL,
  `wfcl_logo` varchar(255) NOT NULL,
  `wfcl_banner` varchar(255) NOT NULL,
  `wfcl_microbutton` varchar(255) NOT NULL,
  `wfcl_mainpage` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `wfcl_newsfeed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `wfcl_texthtml` varchar(255) NOT NULL,
  `wfcl_titlelink` varchar(255) NOT NULL,
  `wfcl_newstitle` varchar(255) NOT NULL,
  `wfcl_content` varchar(255) NOT NULL,
  `wfcl_caption` varchar(255) NOT NULL DEFAULT '',
  `dohtml` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dosmiley` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `doxcode` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `doimage` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `dobr` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`wfcl_id`),
  KEY `wfcl_textlink` (`wfcl_textlink`),
  KEY `wfcl_mainpage` (`wfcl_mainpage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table `wfclink`
#

INSERT INTO `wfclink` (`wfcl_id`, `wfcl_submenu`, `wfcl_textlink`, `wfcl_image`, `wfcl_button`, `wfcl_logo`, `wfcl_banner`, `wfcl_microbutton`, `wfcl_mainpage`, `wfcl_newsfeed`, `wfcl_texthtml`, `wfcl_titlelink`, `wfcl_newstitle`, `wfcl_content`, `wfcl_caption`, `dohtml`, `dosmiley`, `doxcode`, `doimage`, `dobr`) VALUES(1, 1, 'Change Me', '|300|250', 'poweredby.gif|102|47', 'logo.gif|148|80', 'xoops_banner.gif|300|60', 'microbutton.gif|88|15', 1, 1, '', 'Link to us', 'Xoops WF-Channel Feed', '<p>We welcome you to link to our Web site.  Feel free to create links from any section of your Web site to our articles about your website.  You are also welcome to link to our website directories and other resource pages.</p>', '', 1, 1, 1, 0, 0);

# ############################

#
# Table structure for table `wfcpages`
#

CREATE TABLE `wfcpages` (
  `wfc_cid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `wfc_title` varchar(255) NOT NULL DEFAULT '0',
  `wfc_headline` varchar(255) NOT NULL DEFAULT '0',
  `wfc_content` text NOT NULL,
  `wfc_weight` smallint(5) unsigned NOT NULL DEFAULT '1',
  `wfc_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `wfc_image` varchar(255) DEFAULT NULL,
  `wfc_file` varchar(255) DEFAULT NULL,
  `wfc_usefiletitle` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `wfc_mainmenu` smallint(1) unsigned NOT NULL DEFAULT '0',
  `wfc_submenu` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `wfc_created` int(11) unsigned NOT NULL DEFAULT '0',
  `wfc_publish` int(11) unsigned NOT NULL DEFAULT '0',
  `wfc_expired` int(11) unsigned NOT NULL DEFAULT '0',
  `wfc_counter` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `wfc_comments` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `wfc_allowcomments` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `wfc_uid` int(8) unsigned NOT NULL DEFAULT '0',
  `dohtml` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `doxcode` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `dosmiley` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `doimage` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `dobr` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `wfc_metakeywords` text NOT NULL,
  `wfc_metadescription` text NOT NULL,
  `wfc_related` varchar(255) NOT NULL DEFAULT '0',
  `wfc_author` varchar(255) NOT NULL DEFAULT '0',
  `wfc_caption` varchar(255) NOT NULL DEFAULT '0',
  `wfc_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wfc_cid`),
  KEY `wfc_title` (`wfc_title`),
  KEY `wfc_publish` (`wfc_publish`),
  KEY `wfc_expired` (`wfc_expired`),
  KEY `wfc_default` (`wfc_default`)
) ENGINE=MyISAM AUTO_INCREMENT=6 ;

#
# Dumping data for table `wfcpages`
#

INSERT INTO `wfcpages` (`wfc_cid`, `wfc_title`, `wfc_headline`, `wfc_content`, `wfc_weight`, `wfc_default`, `wfc_image`, `wfc_file`, `wfc_usefiletitle`, `wfc_mainmenu`, `wfc_submenu`, `wfc_created`, `wfc_publish`, `wfc_expired`, `wfc_counter`, `wfc_comments`, `wfc_allowcomments`, `wfc_uid`, `dohtml`, `doxcode`, `dosmiley`, `doimage`, `dobr`, `wfc_metakeywords`, `wfc_metadescription`, `wfc_related`, `wfc_author`, `wfc_caption`, `wfc_active`) VALUES(1, 'Welcome', 'Welcome to WF-Channel', '<p>Firstly, many thanks for downloading and trying WF-Channel, a module created by the Xoosla Module team. We hope that this module suits your needs and hopefully, helps in some way to helping you create a website that you are looking for.</p><p>What is WF-Channel? This module will allow you to add content quickly and easily to your existing website, without the need to edit any html or having to upload files to your web server.</p><p>With WF-Channel, you can add many different pages, either as a standalone page or as part as one of the Menus that is provided within WF-Channel. This means that you are not restricted to having the category/article listing and each page can become an separate identity within your website.</p><p>Just about every part of WF-Channel can be changed to suit your needs, from the ability to display a menu title or not. This is the same for the icons, book marks and much more, and this gives you the freedom to have each page different from the other.</p><p>The administration of WF-Channel is totally different from any other module. It is easier to navigate and with many tools available to make the creation and administration of Pages easily as possible.&nbsp; You have the ability to mash update, duplicate and delete pages all at once just by a few clicks.</p><p>WF-Channel has the ability to search pages from the admin area, whether this is by their menu title, page title, content, related tags or publication date. This makes admiration a little simpler when dealing with many pages at a time.</p>', 0, 1, 'welcome.jpg|300|250', '', 0, 1, 1, 1239012050, 1239862440, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 'WF-Channel Welcome', 'The welcome page to the all new WF-Channel', 'WF-Channel', '', 'Welcome To WF-Channel', 1);
INSERT INTO `wfcpages` (`wfc_cid`, `wfc_title`, `wfc_headline`, `wfc_content`, `wfc_weight`, `wfc_default`, `wfc_image`, `wfc_file`, `wfc_usefiletitle`, `wfc_mainmenu`, `wfc_submenu`, `wfc_created`, `wfc_publish`, `wfc_expired`, `wfc_counter`, `wfc_comments`, `wfc_allowcomments`, `wfc_uid`, `dohtml`, `doxcode`, `dosmiley`, `doimage`, `dobr`, `wfc_metakeywords`, `wfc_metadescription`, `wfc_related`, `wfc_author`, `wfc_caption`, `wfc_active`) VALUES(2, 'Getting started', 'Getting started', '<p>The first thing you may want to do is create a new page, this is quite simple and easy to do. The basics require nothing more than a few simple steps to creating your new page.&nbsp; While all the tabs may look daunting at first, you will soon quickly realise that this procedure has been broken down into more easy manageable steps.</p><p>To create new pages simply follow these instructions.</p><ol start="1" type="1"><li>Navigate to the Xoops Administration and locate the WF-Channel module.</li><li>Once there, look for the create button that appears at the top right hand side. Please click this.</li><li>Once you have navigated to the &lsquo;New Page&rsquo; location, you will be presented with a form with a few tabs, &lsquo;Main, Publish, Image, Meta and Permissions. Each tab will allow you to manipulate the Page in a different way or to enhance the page in a certain way. But for now we will stick with the important tabs that will allow us to create our first page.</li><li>First, make sure that the &lsquo;Main&rsquo; tab is the active one.</li><li>The first field, Menu Title is the only required field within the form, so we have to make sure that we enter this field.</li><li>The next field is the &lsquo;Page Title&rsquo;. This is a general heading to convey to people what or page is trying to tell them in a quick concise manner. Try to keep this short and as straight to the point as much as you can.</li><li>Next we have the &lsquo;Page Content&rsquo;. This is the most important part of your page makeup and can be about anything that you desire. To make the page span over different pages you can use the [ pagebreak ] tag.</li><li>Rather than using text and html, you may consider using a page wrap to include your html files as the content of your page.&nbsp; The &lsquo;Page Wrap&rsquo; will allow you to enter the path of the html file and import the contents straight into the database or only when the Page is read. (This content will be cached for quicker loading).</li><li>The last item on this page will allow you to perform certain cleaning options is you so desire.<ol start="1" type="a"><li>Raw Formatting: Do nothing and leave the text as it was entered.</li><li>Html Cleansing: Check and clean any errors found in the html. This also includes compressing and make sure the html will comply with xhtml standards.</li><li>MS Word Cleaning: If you copy and paste straight from a Microsoft Word document, you will know that this can cause problems with formatting and extra garbage that is not required. It is recommended that you perform this action on MS word text.</li><li>This is a totally destructive mode. It will remove all html formatting and leave just plain text.</li></ol></li><li>The last step before we save our new page is to make sure that the right people have permission to view this page. This can be done by granting certain groups &lsquo;permissions&rsquo;. This can be achieved by clicking on the &lsquo;Permissions&rsquo; tab at the very end&rsquo; (Don&rsquo;t worry you will not lose your changes unless you navigate away from this form). Click the checkboxes nest to the groups that you wish to have permissions or simply click the &lsquo;Check All&rsquo; to give everyone permission to view this page.</li></ol><p>These are the first simple steps in creating a new page easily and quickly.</p>', 1, 0, 'under_construction.png|300|250', '', 0, 1, 1, 1239084578, 1239084480, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 'WF-Channel getting started', 'How to get started with WF-Channel and adding a new page', 'WF-Channel', '', 'Were just getting started', 1);
INSERT INTO `wfcpages` (`wfc_cid`, `wfc_title`, `wfc_headline`, `wfc_content`, `wfc_weight`, `wfc_default`, `wfc_image`, `wfc_file`, `wfc_usefiletitle`, `wfc_mainmenu`, `wfc_submenu`, `wfc_created`, `wfc_publish`, `wfc_expired`, `wfc_counter`, `wfc_comments`, `wfc_allowcomments`, `wfc_uid`, `dohtml`, `doxcode`, `dosmiley`, `doimage`, `dobr`, `wfc_metakeywords`, `wfc_metadescription`, `wfc_related`, `wfc_author`, `wfc_caption`, `wfc_active`) VALUES(3, 'Publication Options', 'Publication Options', '<p>With any other article management module, it is important that we can change certain areas of a pages publication, the publish date, expire date or even the author of the Page and now this is no different WF-Channel.</p><ol start="1" type="1"><li>Author Name: You can select which name to publish a Page using the pull down menu. Even though you may have written the page, you can still choose to select a different author.</li><li>Enter Author Alias: Rather than displaying a username, you can select to use an author alias as the Page writer, simply enter the desired name you wish to use as the author name.</li><li>Page Weight: This will dictate where in the order of Page menu that this page will be displayed, the lower the number the sooner is will be displayed, and the higher the number will push the page title further down the menu listing.</li><li>Page Publish Date: This will be the date shown as the publish date, you can select any date and if the date happens to be in the future, the Page will not be displayed until that point.</li><li>Page Expire Date: Sometimes it is necessary to have a page displayed for a certain amount of time and then have it expire. With this option, you can set the date of expire and have the Page automatically expire without the need for admin intervention.</li><li>Set Page Status: With this option, you can quickly set the publication options of a page, or they can be used to gauge the actually publication status of a page.<ol start="1" type="a"><li>Published: Set the Page as published</li><li>Unpublished: Set the Page to a non published state. This page will not show in the page menu until it is published again.</li><li>Expired: Set the Page as expired.</li><li>Inactive: Sometimes it is required to set a page offline but not to change the actual publication status of the Page. This option will allow you to do this.</li></ol></li><li>Default Page:&nbsp; Select to have the current Page as the default one. &nbsp;If selected this Page will show as the main page over all other Pages. If another page was the default, this will lose its default page status in favour of the new one.</li><li>Channel link: Using this option with allow the page to become part of the Page menu and displayed in the links</li><li>Channel Block Menu: Selecting this option will make this part of the WF-Channel Menu Block (Main Menu Clone Block for WF-Channel).</li><li>Show Comments: Select to allow and display comments for the current page.</li></ol>', 2, 0, 'publish.png|300|250', '', 0, 1, 1, 1239084739, 1239084600, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 'WF-Channel publications Publish Expire User name Display Name', 'WF-Channel and changing the publication options', 'WF-Channel', 'WF-Channel', 'Another article to publish', 1);
INSERT INTO `wfcpages` (`wfc_cid`, `wfc_title`, `wfc_headline`, `wfc_content`, `wfc_weight`, `wfc_default`, `wfc_image`, `wfc_file`, `wfc_usefiletitle`, `wfc_mainmenu`, `wfc_submenu`, `wfc_created`, `wfc_publish`, `wfc_expired`, `wfc_counter`, `wfc_comments`, `wfc_allowcomments`, `wfc_uid`, `dohtml`, `doxcode`, `dosmiley`, `doimage`, `dobr`, `wfc_metakeywords`, `wfc_metadescription`, `wfc_related`, `wfc_author`, `wfc_caption`, `wfc_active`) VALUES(4, 'Adding an image', 'Adding an image', '<p>Adding an image to a page is quite a simple task and you can manipulate the size if the image without touching any html and you can add your very own caption underneath, all from the Page Form. First, you may want to upload a new image, you could either do this from using an ftp program, or you can use the inbuilt uploader within WF-Channel.</p><p>To upload an image, please select the upload tab in this administration menu. Once there you will be presented with a few upload options. Simply select the &lsquo;Image Upload Directory&rsquo;, then click the browse button, and select your image from your desktop. To finish the procedure simply click the Submit button. &nbsp;Once the image as been uploaded, you may want to look through the &lsquo;Image View list&rsquo; just to make sure your upload was successful.</p><p>In the main administration window, look through the list of pages until you find the one you want to add this new image too, and click on the edit button. Once we have the Page edit form, click on the image tab. &nbsp;Look through the &lsquo;Page Image&rsquo; list until you find the new image that you previously uploaded and select it. The image will appear next to this list indicating that it is the correct one.</p><p>Underneath the Page Image we have a couple of other options that we can perform on this image. We can enter a new width and height easily and/or we can have the option to add a image &lsquo;Caption&rsquo; underneath our new image once it is displayed in our Page.</p>', 3, 0, 'noimage.jpg|300|250', '', 0, 1, 1, 1239084853, 1239084780, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 'WF-Channel Image', 'How to add an image to WF-Channel', 'WF-Channel', 'WF-Channel', 'They stole our Image', 1);
INSERT INTO `wfcpages` (`wfc_cid`, `wfc_title`, `wfc_headline`, `wfc_content`, `wfc_weight`, `wfc_default`, `wfc_image`, `wfc_file`, `wfc_usefiletitle`, `wfc_mainmenu`, `wfc_submenu`, `wfc_created`, `wfc_publish`, `wfc_expired`, `wfc_counter`, `wfc_comments`, `wfc_allowcomments`, `wfc_uid`, `dohtml`, `doxcode`, `dosmiley`, `doimage`, `dobr`, `wfc_metakeywords`, `wfc_metadescription`, `wfc_related`, `wfc_author`, `wfc_caption`, `wfc_active`) VALUES(5, 'Meta Tags', 'Meta Tags', '<p>To help with search engine friendliness, WF-Channel has the ability to change the Meta tags terms for each page. If you are unsure of what you should be using for this part of the Form, it is suggested that you read about Meta Tags and their usages first.</p><ol start="1" type="1"><li>Meta Keywords: Enter the Meta Keywords you wish to display in the Meta tags.</li><li>Meta Description: Enter the Meta Tag Description to use with this page.</li><li>Related Pages Tags: This option allows you to tie this Page with another one, by simply using a keyword or tag within another page. This keyword/s can be in the Menu Title, Page Title, and Page Content or within the Related Pages Tags. Any page found matching these criteria will be displayed below this Page Content.</li></ol>', 4, 0, 'metatags.png|300|250', '', 0, 1, 1, 1239084978, 1239084900, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 'WF-Channel Xoosla Modules Meta Tags Keywords', 'How to add met tags to WF-Channel', 'WF-Channel', 'WF-Channel', 'Adding Meta Tags is easy now', 1);

# ############################

#
# Table structure for table `wfcrefer`
#

CREATE TABLE `wfcrefer` (
  `wfcr_id` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `wfcr_title` varchar(60) NOT NULL,
  `wfcr_content` text NOT NULL,
  `wfcr_mainpage` smallint(1) unsigned NOT NULL DEFAULT '0',
  `wfcr_image` varchar(255) NOT NULL,
  `wfcr_email` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `wfsr_ublurb` smallint(1) unsigned NOT NULL DEFAULT '0',
  `wfcr_dblurb` text NOT NULL,
  `wfcr_privacy` smallint(1) unsigned NOT NULL DEFAULT '1',
  `wfcr_emailcheck` smallint(1) unsigned NOT NULL DEFAULT '1',
  `wfcr_privacytext` text NOT NULL,
  `wfcr_counter` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `wfcr_caption` varchar(255) NOT NULL DEFAULT '',
  `dohtml` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `doxcode` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `dosmiley` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `doimage` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `dobr` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`wfcr_id`),
  KEY `wfcr_title` (`wfcr_title`),
  KEY `wfcr_mainpage` (`wfcr_mainpage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table `wfcrefer`
#

INSERT INTO `wfcrefer` (`wfcr_id`, `wfcr_title`, `wfcr_content`, `wfcr_mainpage`, `wfcr_image`, `wfcr_email`, `wfsr_ublurb`, `wfcr_dblurb`, `wfcr_privacy`, `wfcr_emailcheck`, `wfcr_privacytext`, `wfcr_counter`, `wfcr_caption`, `dohtml`, `doxcode`, `dosmiley`, `doimage`, `dobr`) VALUES(1, 'Refer a friend', '<p>Let a friend know about us.</p>', 1, '|300|250', 1, 1, 'Please visit this fantastic website that I have just found.', 1, 1, 'We will not and do not collect, sell, or distribute in any way or form the email addresses gathered through this referral option. The intended recipient(s) will only receive the following message and no one else.', 1, '', 1, 1, 1, 0, 0);

# ############################

#
# Table structure for table `wfcrefers`
#

CREATE TABLE `wfcrefers` (
  `wfcr_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `wfcr_username` varchar(60) NOT NULL,
  `wfcr_uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `wfcr_referurl` varchar(255) NOT NULL,
  `wfcr_date` int(10) unsigned NOT NULL,
  `wfcr_ip` varchar(20) NOT NULL,
  PRIMARY KEY (`wfcr_id`),
  UNIQUE KEY `wfcr_id` (`wfcr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 ;
