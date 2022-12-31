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
defined('XOOPS_ROOT_PATH') || exit('You do not have permission to access this file!');

define('_MD_WFC_NORIGHTTOVIEWPAGE', 'Selected page not found');
define('_MD_WFC_TEXTLINKEXAMPLE', 'Example of text link: ');
define('_MD_WFC_BUTTONLINKEXAMPLE', 'Example of button link:');
define('_MD_WFC_LOGOLINKEXAMPLE', 'Example of logo link:');
define('_MD_WFC_BANNERLINKEXAMPLE', 'Example of banner link:');
define('_MD_WFC_NEWSFEEDLINKEXAMPLE', 'Address to our newsfeed file:');
define('_MD_WFC_NEWSFEEDJSLINKEXAMPLE', 'Address to our Javascript newsfeed:');
define('_MD_WFC_DISPLAYSCRIPT', 'Copy and paste the code below into your own page');
define('_MD_WFC_DISPLAYTEXTLINK', 'How to add in YOUR website a text link to OUR site');
define('_MD_WFC_DISPLAYBUTTONLINK', 'How to display OUR button [102 x 47 pixels] on YOUR website');
define('_MD_WFC_DISPLAYLOGOLINK', 'How to display OUR logo [148 x 80 pixels] on YOUR website');
define('_MD_WFC_DISPLAYBANNERLINK', 'How to display OUR banner [468 x 60 pixels] on YOUR website');
define('_MD_WFC_DISPLAYMICROLINK', 'How to display OUR microbutton [80 x 15 pixels] on YOUR website');
define('_MD_WFC_MIRCOLINKEXAMPLE', 'Example of microbutton link:');
define('_MD_WFC_DISPLAYNEWSLINK', 'How to display OUR news on YOUR website');
define('_MD_WFC_DISPLAYNEWSRSSLINK', '* If your website supports RSS feeds, you can use the following script to display OUR newsfeed on YOUR website.');
define('_MD_WFC_DISPLAYJSNEWSRSSLINK', '* If your website does not support RSS feeds, we\'ve made available a simple Javascript which will display OUR news on YOUR website.');
define('_MD_WFC_COPYRIGHTNOTICE', 'All images and scripts are copyright &copy; ' . $GLOBALS['xoopsConfig']['sitename'] . ' and express permission has been granted for them to be used the way they where intended.');
define('_MD_WFC_SENDERNAME', 'Enter your name');
define('_MD_WFC_SENDEREMAIL', 'Enter your E-mail');
define('_MD_WFC_RECPINAME', 'Enter recipient\'s name');
define('_MD_WFC_RECPIEMAIL', 'Enter recipient\'s E-mail* (Required)');
define('_MD_WFC_WRITEBLURB', 'Enter your message (HTML tags disallowed)');
define('_MD_WFC_EMAILSENT', 'Thank-you for using this service. Your E-mail has been sent to the recipient');
define('_MD_WFC_VISIT', 'Please visit this URL');
define('_MD_WFC_YOURFRIEND', 'friend');
define('_MD_WFC_MESSAGESUBECT', ' has referred you to our website');
define('_MD_WFC_MESSAGETITLE', 'You have been referred to our website by ');
define('_MD_WFC_EMAILSENDSENTERROR', 'The senders email addresses you have entered is either incorrect or empty, please try again.');
define('_MD_WFC_EMAILRECPSENTERROR', 'The recipient\'s email addresses you have entered is incorrect or empty, please try again.');
define('_MD_WFC_EMAILSENTWITHERRORS', 'Sorry, but we have encountered an internal error.  Your email has not been sent.');
define('_MD_WFC_RETURNTOWHEREYOUWHERE', 'Return to previous page');
define('_MD_WFC_FILEERROR', 'WARNING: Error opening required HTMLfile!');
define('_MD_WFC_NAVPAGE', 'Page: ');
define('_MD_WFC_CAPTCHA', 'Please enter the letters in the image as you see them.');
define('_MD_WFC_CAPTCHA_ERROR', 'Please enter the letters in the image as you see them.');
define('_MD_WFC_ERRORS', 'WFChannel Errors.');
define('_MD_WFC_CAPTCHA_ERRORSEND', 'The captcha you entered did not match the one that we have stored. Please go back and try again');
define('_MD_WFC_SORRY_ERRORSEND', 'Sorry But there was a problem sending your email');
define('_MD_WFC_GOBACKBUTTON', 'Go Back');
define('_MD_WFC_NOTITLESET', 'No Default Page');
define('_MD_WFC_NOCONTENTSET', 'You are seeing this page as you have no default page setup. Go into the module admin area and select a page that you would like to have as your default page.');
define('_MD_WFC_BANNED_HEADER', 'Banned IPaddress');
define(
    '_MD_WFC_BANNED_TEXT',
    '<div>Sorry, it seems that your IP address has been banned from using this system.</div><br>
<div>If you feel this is in error, please contact ' . $GLOBALS['xoopsConfig']['adminmail'] . ' stating the reason you feel this has been in error or judged wrong.</div><br>
<div>Thank-you</div>'
);
define('_MD_WFC_EMAILERROR_HEADER', 'Error Sending Email');
define(
    '_MD_WFC_EMAILERROR_TEXT',
    '<div>Sorry, it seems that you have not entered a valid email address for the recipent or for the sender. Please go back and try again</div><br>
<div>If you feel this is in error, please contact ' . $GLOBALS['xoopsConfig']['adminmail'] . ' stating there has been an error and any information you think we need to know that may help towards correcting this.</div><br>
<div>Thank-you</div>'
);
define('_MD_WFC_PDF_NEW_PAGE', 'New Page');
define('_MD_WFC_INTARTICLE', 'Interesting Article at %s');
define('_MD_WFC_INTARTFOUND', 'Here is an interesting article I have found at %s');
define('_MD_WFC_HOME', 'Home');
define('_MD_WFC_COUNTER', 'Read:');
/**
 * quick fix
 */
if (!defined('_MD_WFC_ADMINTASKS')) {
    define('_MD_WFC_ADMINTASKS', 'Admin Task: ');
}

define('_MD_WFC_UPDATE1', 'Update');
define('_MD_WFC_UPDATE2', 'Update');
define('_MD_WFC_UPDATE3', 'Update');
define('_MD_WFC_UPDATE4', 'Update');
define('_MD_WFC_UPDATE5', 'Update');
define('_MD_WFC_UPDATE6', 'Update');
define('_MD_WFC_UPDATE24', 'Update');
define('_MD_WFC_SUCCESS', 'Update');
define('_MD_WFC_NOTHING_UPDATED', 'Update');
define('_MD_WFC_FAILURE', 'Update');
define('_MD_WFC_NO_ERRORSFOUND', 'Update');
