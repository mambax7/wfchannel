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

require_once __DIR__ . '/preloads/autoloader.php';

$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

// ------------------- Information ------------------- /
$modversion = [
    'version'             => '3.0.0',
    'requires'            => '2.0.0', //wf-resource
    'module_status'       => 'Alpha 1',
    'release_date'        => '2022/12/31', //yyyy/mm/dd
    'name'                => _MI_WFC_CHANNEL,
    'description'         => _MI_WFC_CHANNELDESC,
    'official'            => 0, //1 indicates supported by XOOPS Dev Team, 0 means 3rd party supported
    'author'              => 'John Neill, Mamba',
    'author_mail'         => 'author-email',
    'author_website_url'  => 'https://xoops.org',
    'author_website_name' => 'XOOPS',
    'credits'             => 'I would like to thank all the people who in some way or another who have either helped with coding or contributed with the development of this module. Mark Boyden, many thanks for your contribution and help with the development of this module..and you may get your wish yet! ;-)',
    'contributors'        => 'Predator, Phppp, Bender, giba and many others. Thank you :)',
    'disclaimer'          => _MI_WFC_CHANNELDISCLAIMER,
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    'help'                => 'page=help',

    'release_info' => 'Changelog',
    'release_file' => XOOPS_URL . "/modules/{$moduleDirName}/docs/changelog file",

    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . "/modules/{$moduleDirName}/docs/install.txt",
    'min_php'             => '7.4',
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.5'],
    // images
    'image'               => 'assets/images/logoModule.png',
    'iconsmall'           => 'assets/images/iconsmall.png',
    'iconbig'             => 'assets/images/iconbig.png',
    'dirname'             => $moduleDirName,
    //Frameworks
    //    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    //    'sysicons16'          => 'Frameworks/moduleclasses/icons/16',
    //    'sysicons32'          => 'Frameworks/moduleclasses/icons/32',
    // Local path icons
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    //    'release'             => '2015-04-04',
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // paypal
    //    'paypal'              => array(
    //        'business'      => 'XXX@email.com',
    //        'item_name'     => 'Donation : ' . _MI_WFC_CHANNELDESC,
    //        'amount'        => 0,
    //        'currency_code' => 'USD'),
    // Admin system menu
    'system_menu'         => 1,
    // Admin menu
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // Main menu
    'hasMain'             => 1,
    //Search & Comments
    'hasSearch'           => 1,
    'search'              => [
        'file' => 'include/search.inc.php',
        'func' => $moduleDirName . '_search',
    ],
    'hasComments'         => 1,
    'comments'            => [
        'pageName'     => 'index.php',
        'itemName'     => 'cid',
        'callbackFile' => 'include/comment_functions.php',
        'callback'     => [
            'approve' => 'wfchannel_com_approve',
            'update'  => 'wfchannel_com_update',
        ],
    ],
    // Install/Update
    'onInstall'           => 'include/oninstall.php',
    'onUpdate'            => 'include/onupdate.php',
    'onUninstall'         => 'include/onuninstall.php',
];

// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'] = [
    'wfcpages',
    'wfclink',
    'wfcrefer',
    'wfcrefers',
];

// Comment callback functions
//$modversion['comments']['callbackFile']        = 'include/comment_functions.php';
//$modversion['comments']['callback']['approve'] = 'wfchannel_com_approve';
//$modversion['comments']['callback']['update']  = 'wfchannel_com_update';

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => _MI_WFC_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_WFC_REQUIREMENTS, 'link' => 'page=__requirements'],
    ['name' => _MI_WFC_INSTALL, 'link' => 'page=__install'],
    ['name' => _MI_WFC_UPDATE, 'link' => 'page=__update'],
    ['name' => _MI_WFC_HOWTO, 'link' => 'page=__howto'],
    ['name' => _MI_WFC_CREDITS, 'link' => 'page=__credits'],
    ['name' => _MI_WFC_DISCLAIMER, 'link' => 'page=__disclaimer'],
    ['name' => _MI_WFC_LICENSE, 'link' => 'page=__license'],
    ['name' => _MI_WFC_SUPPORT, 'link' => 'page=__support'],
];

/**
 * Notifications
 */
$modversion['hasNotification']             = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'wfchannel_notify_iteminfo';

$modversion['notification']['category'][] = [
    'name'           => 'global',
    'title'          => _MI_WFC_GLOBALNOTIFYCAT_TITLE,
    'description'    => '_MI_WFC_GLOBALNOTIFYCAT_DESC',
    'subscribe_from' => ['index.php'],
    'item_name'      => '',
];

$modversion['notification']['category'][] = [
    'name'           => 'page',
    'title'          => _MI_WFC_PAGENOTIFYCAT_TITLE,
    'description'    => '_MI_WFC_PAGENOTIFYCAT_DESC',
    'subscribe_from' => ['index.php'],
    'allow_bookmark' => 1,
    'item_name'      => 'cid',
];

$modversion['notification']['event'][] = [
    'name'          => 'page_modified',
    'category'      => 'global',
    'title'         => _MI_WFC_GLOBALNOTIFY_TITLE,
    'caption'       => _MI_WFC_GLOBALNOTIFY_CAPTION,
    'description'   => '_MI_WFC_GLOBALNOTIFY_DESC',
    'mail_template' => 'global_pagemodified_notify',
    'mail_subject'  => '_MI_WFC_GLOBALNOTIFY_SUBJECT',
];

$modversion['notification']['event'][] = [
    'name'          => 'page_new',
    'category'      => 'global',
    'title'         => _MI_WFC_GLOBALNEWNOTIFY_TITLE,
    'caption'       => _MI_WFC_GLOBALNEWNOTIFY_CAPTION,
    'description'   => '_MI_WFC_GLOBALNEWNOTIFY_DESC',
    'mail_template' => 'global_pagenew_notify',
    'mail_subject'  => '_MI_WFC_GLOBALNEWNOTIFY_SUBJECT',
];

$modversion['notification']['event'][] = [
    'name'          => 'page_modified',
    'category'      => 'page',
    'title'         => _MI_WFC_PAGENOTIFY_TITLE,
    'caption'       => _MI_WFC_PAGENOTIFY_CAPTION,
    'description'   => '_MI_WFC_PAGENOTIFY_DESC',
    'mail_template' => 'global_pagemodified_notify',
    'mail_subject'  => '_MI_WFC_PAGENOTIFY_SUBJECT',
];

$modversion['notification']['event'][] = [
    'name'          => 'page_new',
    'category'      => 'page',
    'title'         => _MI_WFC_PAGENEWNOTIFY_TITLE,
    'caption'       => _MI_WFC_PAGENEWNOTIFY_CAPTION,
    'description'   => '_MI_WFC_PAGENEWNOTIFY_DESC',
    'mail_template' => 'global_pagenew_notify',
    'mail_subject'  => '_MI_WFC_PAGENEWNOTIFY_SUBJECT',
];

// ------------------- Blocks ------------------- //
$modversion['blocks'][] = [
    'file'        => 'wfc_block.new.php',
    'name'        => _MI_WFC_BLOCK1,
    'description' => _MI_WFC_BLOCK1_DESC,
    'show_func'   => 'b_wfc_new_show',
    'edit_func'   => 'b_wfc_new_edit',
    'options'     => 'published|10|19|M/d/Y|' . $modversion['dirname'],
    'template'    => 'wfchannel_block_new.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'wfc_block.menu.php',
    'name'        => _MI_WFC_BLOCK2,
    'description' => _MI_WFC_BLOCK2_DESC,
    'show_func'   => 'b_wfc_menu_show',
    'edit_func'   => 'b_wfc_menu_edit',
    'options'     => 'weight|10|19|' . $modversion['dirname'],
    'template'    => 'wfchannel_block_menu.tpl',
];

// ------------------- Templates ------------------- //

$modversion['templates'] = [
    // User
    ['file' => $moduleDirName . '_index.tpl', 'description' => _MI_WFC_TPL1_DESC],
    ['file' => $moduleDirName . '_linktous.tpl', 'description' => _MI_WFC_TPL2_DESC],
    ['file' => $moduleDirName . '_refer.tpl', 'description' => _MI_WFC_TPL3_DESC],
    ['file' => $moduleDirName . '_banned.tpl', 'description' => _MI_WFC_TPL4_DESC],
    ['file' => $moduleDirName . '_channellinks.tpl', 'description' => _MI_WFC_TPL5_DESC],
    ['file' => $moduleDirName . '_emailerror.tpl', 'description' => _MI_WFC_TPL6_DESC],
];

$modversion['config'][] = [
    'name'        => 'htmluploaddir',
    'title'       => '_MI_WFC_HTMLUPLOADDIR',
    'description' => '_MI_WFC_HTMLUPLOADDIRDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'modules/' . $modversion['dirname'] . '/html',
];

$modversion['config'][] = [
    'name'        => 'uploaddir',
    'title'       => '_MI_WFC_UPLOADDIR',
    'description' => '_MI_WFC_UPLOADDIRDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'modules/' . $modversion['dirname'] . '/images',
];

$modversion['config'][] = [
    'name'        => 'linkimages',
    'title'       => '_MI_WFC_LINKIMAGES',
    'description' => '_MI_WFC_UPLOADDIRDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'modules/' . $modversion['dirname'] . '/images/linkimages',
];

$modversion['config'][] = [
    'name'        => 'maxfilesize',
    'title'       => '_MI_WFC_MAXFILESIZE',
    'description' => '_MI_WFC_MAXFILESIZEDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 120000,
];

$modversion['config'][] = [
    'name'        => 'maximgwidth',
    'title'       => '_MI_WFC_IMGWIDTH',
    'description' => '_MI_WFC_IMGWIDTHDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 600,
];

$modversion['config'][] = [
    'name'        => 'maximgheight',
    'title'       => '_MI_WFC_IMGHEIGHT',
    'description' => '_MI_WFC_IMGHEIGHTDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 600,
];

$modversion['config'][] = [
    'name'        => 'perpage',
    'title'       => '_MI_WFC_PERPAGE',
    'description' => '_MI_MYDOWNLOADS_PERPAGEDSC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 10,
    'options'     => ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50],
];

$modversion['config'][] = [
    'name'        => 'displaypagetitle',
    'title'       => '_MI_WFC_DISPLAYTITLE',
    'description' => '_MI_WFC_DISPLAYTITLEDSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

xoops_load('XoopsEditorHandler');
$editorHandler = XoopsEditorHandler::getInstance();
$editorList    = array_flip($editorHandler->getList());

$modversion['config'][] = [
    'name'        => 'use_wysiwyg',
    'title'       => '_MI_WFC_WYSIWYG',
    'description' => '_MI_WFC_WYSIWYGDSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => $editorList,
];

$modversion['config'][] = [
    'name'        => 'banned',
    'title'       => '_MI_WFC_BANNED',
    'description' => '_MI_WFC_BANNEDDSC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => '',
];

$modversion['config'][] = [
    'name'        => 'displaybookmarks',
    'title'       => '_MI_WFC_BOOKMARK',
    'description' => '_MI_WFC_BOOKMARKDSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
];

$modversion['config'][] = [
    'name'        => 'allowaddthiscode',
    'title'       => '_MI_WFC_ALLOWADDTHISCODE',
    'description' => '_MI_WFC_ALLOWADDTHISCODE_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
];

$modversion['config'][] = [
    'name'        => 'addthiscode',
    'title'       => '_MI_WFC_ADDTHISCODE',
    'description' => '_MI_WFC_ADDTHISCODE_DSC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => '',
];

$modversion['config'][] = [
    'name'        => 'bookmarktextadd',
    'title'       => '_MI_WFC_ALLOWBMTEXT',
    'description' => '_MI_WFC_ALLOWBMTEXT_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
];

$modversion['config'][] = [
    'name'        => 'bookmarklayout',
    'title'       => '_MI_WFC_BMLAYOUT',
    'description' => '_MI_WFC_BMLAYOUT_DSC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => '0',
    'options'     => [
        _MI_WFC_HORIZONTAL => 0,
        _MI_WFC_VERTICAL   => 1,
    ],
];

$modversion['config'][] = [
    'name'        => 'menulinks',
    'title'       => '_MI_WFC_MENULINKS',
    'description' => '_MI_WFC_MENULINKSDSC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 3,
    'options'     => ['None' => 0, 'Both' => 1, 'Top' => 2, 'Bottom' => 3],
];

$modversion['config'][] = [
    'name'        => 'pageicon',
    'title'       => '_MI_WFC_DISPLAYICONS',
    'description' => '_MI_WFC_DISPLAYICONS_DSC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => [1, 2, 3, 4, 5],
    'options'     => [
        '_MI_WFC_NONE'           => 0,
        '_MI_WFC_RSS_ICON'       => 1,
        '_MI_WFC_PRINT_ICON'     => 2,
        '_MI_WFC_PDF_ICON'       => 3,
        '_MI_WFC_EMAILICON_ICON' => 4,
        '_MI_WFC_BOOKMARK_ICON'  => 5,
    ],
];

$modversion['config'][] = [
    'name'        => 'act_refer',
    'title'       => '_MI_WFC_ACTIVATEREFERS',
    'description' => '_MI_WFC_ACTIVATEREFERS_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
];

$modversion['config'][] = [
    'name'        => 'act_link',
    'title'       => '_MI_WFC_ACTIVATELINKS',
    'description' => '_MI_WFC_ACTIVATELINKS_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
];

$modversion['config'][] = [
    'name'        => 'allow_admin',
    'title'       => '_MI_WFC_ALLOWADMIN',
    'description' => '_MI_WFC_ALLOWADMIN_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
];

$modversion['config'][] = [
    'name'        => 'xoopstags',
    'title'       => '_MI_WFC_XOOPSTAGS',
    'description' => '_MI_WFC_XOOPSTAGS_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
];

$modversion['config'][] = [
    'name'        => 'copyrighttext',
    'title'       => '_MI_WFC_COPYRIGHT',
    'description' => '_MI_WFC_COPYRIGHT_DSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'Copyright © %s %s',
];

$modversion['config'][] = [
    'name'        => 'allow_pnlinks',
    'title'       => '_MI_WFC_PNKINKS',
    'description' => '_MI_WFC_PNKINKS_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
];

/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
