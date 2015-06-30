<?php
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
defined('XOOPS_ROOT_PATH') || exit('You do not have permission to access this file!');

define('_MD_WFCHANNEL_NORIGHTTOVIEWPAGE', 'Selected page not found');
define('_MD_WFCHANNEL_TEXTLINKEXAMPLE', 'Example of text link: ');
define('_MD_WFCHANNEL_BUTTONLINKEXAMPLE', 'Example of button link:');
define('_MD_WFCHANNEL_LOGOLINKEXAMPLE', 'Example of logo link:');
define('_MD_WFCHANNEL_BANNERLINKEXAMPLE', 'Example of banner link:');
define('_MD_WFCHANNEL_NEWSFEEDLINKEXAMPLE', 'Address to our newsfeed file:');
define('_MD_WFCHANNEL_NEWSFEEDJSLINKEXAMPLE', 'Address to our Javascript newsfeed:');
define('_MD_WFCHANNEL_DISPLAYSCRIPT', 'Copy and paste the code below into your own page');
define('_MD_WFCHANNEL_DISPLAYTEXTLINK', 'How to add in YOUR website a text link to OUR site');
define('_MD_WFCHANNEL_DISPLAYBUTTONLINK', 'How to display OUR button [102 x 47 pixels] on YOUR website');
define('_MD_WFCHANNEL_DISPLAYLOGOLINK', 'How to display OUR logo [148 x 80 pixels] on YOUR website');
define('_MD_WFCHANNEL_DISPLAYBANNERLINK', 'How to display OUR banner [468 x 60 pixels] on YOUR website');
define('_MD_WFCHANNEL_DISPLAYMICROLINK', 'How to display OUR microbutton [80 x 15 pixels] on YOUR website');
define('_MD_WFCHANNEL_MIRCOLINKEXAMPLE', 'Example of microbutton link:');
define('_MD_WFCHANNEL_DISPLAYNEWSLINK', 'How to display OUR news on YOUR website');
define('_MD_WFCHANNEL_DISPLAYNEWSRSSLINK', '* If your website supports RSS feeds, you can use the following script to display OUR newsfeed on YOUR website.');
define('_MD_WFCHANNEL_DISPLAYJSNEWSRSSLINK', '* If your website does not support RSS feeds, we\'ve made available a simple Javascript which will display OUR news on YOUR website.');
define('_MD_WFCHANNEL_COPYRIGHTNOTICE', 'All images and scripts are copyright &copy; ' . $GLOBALS['xoopsConfig']['sitename'] . ' and express permission has been granted for them to be used the way they where intended.');
define('_MD_WFCHANNEL_SENDERNAME', 'Enter your name');
define('_MD_WFCHANNEL_SENDEREMAIL', 'Enter your E-mail');
define('_MD_WFCHANNEL_RECPINAME', 'Enter recipient\'s name');
define('_MD_WFCHANNEL_RECPIEMAIL', 'Enter recipient\'s E-mail* (Required)');
define('_MD_WFCHANNEL_WRITEBLURB', 'Enter your message (HTML tags disallowed)');
define('_MD_WFCHANNEL_EMAILSENT', 'Thank-you for using this service. Your E-mail has been sent to the recipient');
define('_MD_WFCHANNEL_VISIT', 'Please visit this URL');
define('_MD_WFCHANNEL_YOURFRIEND', 'friend');
define('_MD_WFCHANNEL_MESSAGESUBECT', ' has referred you to our website');
define('_MD_WFCHANNEL_MESSAGETITLE', 'You have been referred to our website by ');
define('_MD_WFCHANNEL_EMAILSENDSENTERROR', 'The senders email addresses you have entered is either incorrect or empty, please try again.');
define('_MD_WFCHANNEL_EMAILRECPSENTERROR', 'The recipient\'s email addresses you have entered is incorrect or empty, please try again.');
define('_MD_WFCHANNEL_EMAILSENTWITHERRORS', 'Sorry, but we have encountered an internal error.  Your email has not been sent.');
define('_MD_WFCHANNEL_RETURNTOWHEREYOUWHERE', 'Return to previous page');
define('_MD_WFCHANNEL_FILEERROR', 'WARNING: Error opening required HTMLfile!');
define('_MD_WFCHANNEL_NAVPAGE', 'Page: ');
define('_MD_WFCHANNEL_CAPTCHA', 'Please enter the letters in the image as you see them.');
define('_MD_WFCHANNEL_CAPTCHA_ERROR', 'Please enter the letters in the image as you see them.');
define('_MD_WFCHANNEL_ERRORS', 'WFChannel Errors.');
define('_MD_WFCHANNEL_CAPTCHA_ERRORSEND', 'The captcha you entered did not match the one that we have stored. Please go back and try again');
define('_MD_WFCHANNEL_SORRY_ERRORSEND', 'Sorry But there was a problem sending your email');
define('_MD_WFCHANNEL_GOBACKBUTTON', 'Go Back');
define('_MD_WFCHANNEL_NOTITLESET', 'No Default Page');
define('_MD_WFCHANNEL_NOCONTENTSET', 'You are seeing this page as you have no default page setup. Go into the module admin area and select a page that you would like to have as your default page.');
define('_MD_WFCHANNEL_BANNED_HEADER', 'Banned IPaddress');
define('_MD_WFCHANNEL_BANNED_TEXT', '<div>Sorry, it seems that your IP address has been banned from using this system.</div><br />
<div>If you feel this is in error, please contact ' . $GLOBALS['xoopsConfig']['adminmail'] . ' stating the reason you feel this has been in error or judged wrong.</div><br />
<div>Thank-you</div>');
define('_MD_WFCHANNEL_EMAILERROR_HEADER', 'Error Sending Email');
define('_MD_WFCHANNEL_EMAILERROR_TEXT', '<div>Sorry, it seems that you have not entered a valid email address for the recipent or for the sender. Please go back and try again</div><br />
<div>If you feel this is in error, please contact ' . $GLOBALS['xoopsConfig']['adminmail'] . ' stating there has been an error and any information you think we need to know that may help towards correcting this.</div><br />
<div>Thank-you</div>');
define('_MD_WFCHANNEL_PDF_NEW_PAGE', 'New Page');
define('_MD_WFCHANNEL_INTARTICLE', 'Interesting Article at %s');
define('_MD_WFCHANNEL_INTARTFOUND', 'Here is an interesting article I have found at %s');
define('_MD_WFCHANNEL_HOME', 'Home');
define('_MD_WFCHANNEL_COUNTER', 'Read:');
/**
 * quick fix
 */
if (!defined('_MD_WFCHANNEL_ADMINTASKS')) {
    define('_MD_WFCHANNEL_ADMINTASKS', 'Admin Task: ');
}
