<?php
/**
 * $Id: modinfo.php 10066 2012-08-13 09:22:47Z beckmi $
 * Module: WF-Channel
 * Version: v1.0.2
 * Release Date: 20 November 2003
 * Author: Catzwolf
 * Licence: GNU
 */
defined('XOOPS_ROOT_PATH') || exit('You do not have permission to access this file!');
// Module Info
// The name of this module
define('_MI_WFC_CHANNEL', 'WF-Channel');
// A brief description of this module
define('_MI_WFC_CHANNELDESC', 'About us type Module');

define('_MI_WFC_CHANNELDISCLAIMER', 'Software downloaded from the WF-Project web site is provided "as is" without warranty of any kind, either express or implied, including, but not limited to, the implied warranties of fitness for a purpose, or the warranty of non-infringement. Without limiting the foregoing, the WF-Project makes no warranty that:

   1. the software will meet your requirements
   2. the software will be uninterrupted, timely, secure or error-free
   3. the results that may be obtained from the use of the software will be effective, accurate or reliable
   4. the quality of the software will meet your expectations
   5. any errors in the software obtained from the WF-Project web site will be corrected.

Software and its documentation made available on the WF-Project web site:

   6. could include technical or other mistakes, inaccuracies or typographical errors. The WF-Project may make changes to the software or documentation made available on its web site.
   7. may be out of date, and the WF-Project makes no commitment to update such materials.

The WF-Project assumes no responsibility for errors or ommissions in the software or documentation available from its web site.

In no event shall the WF-Project be liable to you or any third parties for any special, punitive, incidental, indirect or consequential damages of any kind, or any damages whatsoever, including, without limitation, those resulting from loss of use, data or profits, whether or not the WF-Project has been advised of the possibility of such damages, and on any theory of liability, arising out of or in connection with the use of this software.

The use of the software downloaded through the WF-Project site is done at your own discretion and risk and with agreement that you will be solely responsible for any damage to your computer system or loss of data that results from such activities. No advice or information, whether oral or written, obtained by you from the WF-Project or from the WF-Project web site shall create any warranty for the software.
');
// Names of admin menu items
define('_MI_WFC_ADMENU1', 'Page index');
define('_MI_WFC_ADMENU2', 'New page');
define('_MI_WFC_ADMENU3', 'Refer page');
define('_MI_WFC_ADMENU4', 'Link page');
define('_MI_WFC_ADMENU5', 'Permission');
define('_MI_WFC_ADMENU6', 'Upload');
define('_MI_WFC_ADMENU7', 'Import');
define('_MI_WFC_ADMENU8', 'Refers Mgmt');
// Blocks
define('_MI_WFC_BLOCK1', 'WF-Channel Recent Block');
define('_MI_WFC_BLOCK1_DESC', 'Shows recently added donwload files');
define('_MI_WFC_BLOCK2', 'WF-Channel Menu Block');
define('_MI_WFC_BLOCK2_DESC', 'Shows Main menu type block');
// Other
define('_MI_WFC_MAXFILESIZE', 'Maximum upload size (kb)');
define('_MI_WFC_IMGWIDTH', 'Maximum uploaded images width (px)');
define('_MI_WFC_IMGHEIGHT', 'Maximum uploaded images height (px)');
define('_MI_WFC_UPLOADDIR', 'Images upload directory (No trailing slash)');
define('_MI_WFC_LINKIMAGES', 'Link images upload directory (No trailing slash)');
define('_MI_WFC_HTMLUPLOADDIR', 'HTML files upload directory (No trailing slash)');
define('_MI_WFC_PERPAGE', 'Maximum number of pages to show per page');
// define('_MI_WFC_DISPLAYMENU','Display Menu on Default Page (Good for a Home page)');
define('_MI_WFC_DISPLAYTITLE', 'Display Page Title?');
define('_MI_WFC_DISPLAYTITLEDSC', 'Select whether to display titles on the page or not. ');
define('_MI_WFC_WYSIWYG', 'Select Editor');
define('_MI_WFC_WYSIWYGDSC', 'Please select the editor you would like to use? <br>You maybe required to install an editor before you can use it.');
define('_MI_WFC_BANNED', 'IP Address to Ban:');
define('_MI_WFC_BANNEDDSC', 'The IP address will not be allowed to use the refer section of this module.<br><br>Please seperate each one with |.');
define('_MI_WFC_BOOKMARK', 'Display Bookmarks on pages?');
define('_MI_WFC_BOOKMARKDSC', 'Display various social bookmarking sites on pages. These link to blinklist, fark etc etc.');
define('_MI_WFC_MENULINKS', 'Menu Links');
define('_MI_WFC_MENULINKSDSC',
       'Selects how to display the menu links within the page: <br><br>None: Do not display menu links<br>Both: Display both top and menu links on the page.<br>Top: Only display the meny at the top of the page.<br>Bottom: Only display the menu at the bottom of the page.');
define('_MI_WFC_ACTIVATEREFERS', 'Activate Refers Page: ');
define('_MI_WFC_ACTIVATEREFERS_DSC', 'Select to allow users to view and use the Refers Page.');
define('_MI_WFC_ACTIVATELINKS', 'Activate Links Page: ');
define('_MI_WFC_ACTIVATELINKS_DSC', 'Select to allow users to view and use the links Page.');

define('_MI_WFC_ALLOWADMIN', 'Allow Admin Hits?');
define('_MI_WFC_ALLOWADMIN_DSC', 'Enable to allow administator page hits to count towards the page hit count.');

define('_MI_WFC_ALLOWADDTHISCODE', 'Use AddThis Bookmarks?');
define('_MI_WFC_ALLOWADDTHISCODE_DSC', 'Select yes to use Addthis (http://www.addthis.com) bookmark code. Free Registration is required.');
define('_MI_WFC_ADDTHISCODE', 'AddThis Bookmark Code');
define('_MI_WFC_ADDTHISCODE_DSC', 'Copy and Paste valid AddThis Bookmark code to use as your Bookmarks.');

define('_MI_WFC_ALLOWBMTEXT', 'Add Title Text Bookmarks?');
define('_MI_WFC_ALLOWBMTEXT_DSC', 'This will display a \'Bookmark to\' bookmark along side the Bookmark Icon.<br><br>Notice: Ignored if AddThis Bookmarks are used');
define('_MI_WFC_BMLAYOUT', 'Type Of Bookmark Display?');
define('_MI_WFC_BMLAYOUT_DSC', 'Selecting either of these options will change the display to a Vertical or Horizontal BookMarks.<br><br>Notice: Ignored if AddThis Bookmarks are used');
define('_MI_WFC_HORIZONTAL', 'Horizontal');
define('_MI_WFC_VERTICAL', 'Vertical');

define('_MI_WFC_COPYRIGHT', 'Copyright Notice:');
define('_MI_WFC_COPYRIGHT_DSC', 'Select to display a copyright notice on each page.');

define('_MI_WFC_XOOPSTAGS', 'Enable Xoops Tags:');
define('_MI_WFC_XOOPSTAGS_DSC', 'Enable Xoops Tags module (XoopsTag by DJ) intregation.');

define('_MI_WFC_PNKINKS', 'Show Previous and Next link:');
define('_MI_WFC_PNKINKS_DSC', 'Enabling this option will display previous and next links. Those links are used to go to the previous and next page according to the publish date');

define('_MI_WFC_DISPLAYICONS', 'Display Icons:');
define('_MI_WFC_DISPLAYICONS_DSC', 'Select to enable or disable icons within pages.');
define('_MI_WFC_NONE', 'Display No Icons');
define('_MI_WFC_RSS_ICON', 'RSS Icon');
define('_MI_WFC_PRINT_ICON', 'Print Icon');
define('_MI_WFC_PDF_ICON', 'PDF Icon');
define('_MI_WFC_EMAILICON_ICON', 'Email Icon');
define('_MI_WFC_BOOKMARK_ICON', 'Bookmark Icon');
/**
 * Notifications
 */
/**
 * Pages
 */
define('_MI_WFC_PAGENOTIFYCAT_TITLE', 'Page');
define('_MI_WFC_PAGENOTIFYCAT_DESC', 'Notifications that apply to the current page');
define('_MI_WFC_PAGENOTIFY_TITLE', 'Page updated');
define('_MI_WFC_PAGENOTIFY_CAPTION', 'Notify me when the current page is modified');
define('_MI_WFC_PAGENOTIFY_DESC', 'Receive notification when any user updates the current page.');
define('_MI_WFC_PAGENOTIFY_SUBJECT', '[{X_SITENAME}] {X_MODULE} auto-notify : page updated');
/**
 * Global
 */
define('_MI_WFC_GLOBALNOTIFYCAT_TITLE', 'Global');
define('_MI_WFC_GLOBALNOTIFYCAT_DESC', 'Notifications that apply to the all pages');
define('_MI_WFC_GLOBALNOTIFY_TITLE', 'Page Updated');
define('_MI_WFC_GLOBALNOTIFY_CAPTION', 'Notify me when any page is modified');
define('_MI_WFC_GLOBALNOTIFY_DESC', 'Receive notification when any user updates a page.');
define('_MI_WFC_GLOBALNOTIFY_SUBJECT', '[{X_SITENAME}] {X_MODULE} auto-notify : Page Updated');
/**
 * Global
 */
define('_MI_WFC_GLOBALNEWNOTIFY_TITLE', 'New Page');
define('_MI_WFC_GLOBALNEWNOTIFY_CAPTION', 'Notify me when any new page is posted.');
define('_MI_WFC_GLOBALNEWNOTIFY_DESC', 'Receive notification when any new page is posted.');
define('_MI_WFC_GLOBALNEWNOTIFY_SUBJECT', '[{X_SITENAME}] {X_MODULE} auto-notify : New Page');
/**
 * Global
 */
define('_MI_WFC_PAGENEWNOTIFY_TITLE', 'New Page');
define('_MI_WFC_PAGENEWNOTIFY_CAPTION', 'Notify me when any new page is posted.');
define('_MI_WFC_PAGENEWNOTIFY_DESC', 'Receive notification when any new page is posted.');
define('_MI_WFC_PAGENEWNOTIFY_SUBJECT', '[{X_SITENAME}] {X_MODULE} auto-notify : New Page');

// The name of this module
define('_MI_WFC_NAME', 'WF-Channel');
define('_MI_WFC_DIRNAME', basename(dirname(dirname(__DIR__))));

define('_MI_WFC_OVERVIEW', 'Overview');
define('_MI_WFC_INSTALL', 'Install');
define('_MI_WFC_PREFERENCES', 'Preferences');
define('_MI_WFC_PAGE_INDEX', 'Page index');
define('_MI_WFC_NEW_PAGE', 'New page');
define('_MI_WFC_BLOCK', 'Block');
define('_MI_WFC_PERMISSIONS', 'Permissions');
define('_MI_WFC_REORDER_PAGES', 'Reorder pages');
define('_MI_WFC_UPLOAD', 'Upload');
define('_MI_WFC_SPECIAL_PAGES', 'Special pages');
define('_MI_WFC_EDITORS', 'WYSIWYG Editors');
define('_MI_WFC_TEMPLATES', 'Templates');

// Help topics
define('_MI_WFC_REQUIREMENTS', 'Requirements');
//define('_MI_WFC_INSTALL', 'Install');
define('_MI_WFC_UPDATE', 'Update');
define('_MI_WFC_HOWTO', 'How To');
define('_MI_WFC_HISTORY', 'History');
define('_MI_WFC_CREDITS', 'Credits');
define('_MI_WFC_DESCLAIMER', 'Disclaimer');
define('_MI_WFC_LICENSE', 'License');
define('_MI_WFC_SUPPORT', 'Support');

//Templates

define('_MI_WFC_TPL1_DESC', 'Display index.');
define('_MI_WFC_TPL2_DESC', 'Display Link to Us page.');
define('_MI_WFC_TPL3_DESC', 'Display refer page.');
define('_MI_WFC_TPL4_DESC', 'Display a banned page.');
define('_MI_WFC_TPL5_DESC', 'Display channel links within pages.');
define('_MI_WFC_TPL6_DESC', 'Display channel email error page.');
