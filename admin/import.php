<?php declare(strict_types=1);

/**
 * Name: index.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Wfchannel;
use XoopsModules\Wfresource;

require_once __DIR__ . '/admin_header.php';

xoops_cp_header();

$menuHandler->addHeader(_AM_WFC_UPLOADAREA);

$op = Request::getString('op', 'default'); //Wfresource\Request::doRequest($_REQUEST, 'op', 'default', 'textbox');
switch ($op) {
    case 'save':
        $pageHandler = new Wfchannel\PageHandler($db); //wfp_getHandler('page', _MODULE_DIR, _MODULE_CLASS);
        $do_callback = Wfresource\Utility::getObjectCallback($pageHandler);

        $uploadir = Request::getString('uploadir', ''); //Wfresource\Request::doRequest($_REQUEST, 'uploadir', '', 'textbox');
        if (empty($uploadir) || !is_dir(XOOPS_ROOT_PATH . '/' . $uploadir)
            || !is_readable(XOOPS_ROOT_PATH . '/' . $uploadir)) {
            xoops_cp_header();
            $menuHandler->addSubHeader(_AM_WFC_IMPORT_DSC);
            //            $menuHandler->render(6);
            echo _AM_EWFC_FOLDERDOESNOTEXIST;
            //xoosla_cp_footer();
            require_once __DIR__ . '/admin_footer.php';
        }
        xoops_load('xoopslists');
        $htmlList = \XoopsLists::getHtmlListAsArray(XOOPS_ROOT_PATH . '/' . $uploadir);

        unset($_SESSION['wfc_channel']);
        $do_callback->setBasics();
        $do_callback->setValueArray($_REQUEST);
        $do_callback->setValueTime('wfc_expired', $_REQUEST['wfc_expired']);
        $do_callback->setValueTime('wfc_publish', $_REQUEST['wfc_publish']);
        $do_callback->setValueGroups('page_read', $_REQUEST['page_read'] ?? [0 => '1']);

        $i = 1;
        foreach ($htmlList as $htmlfile) {
            $ret = $do_callback->htmlImport(XOOPS_ROOT_PATH . '/' . $uploadir . '/' . $htmlfile, 1);
            if (isset($ret['content']) && !empty($ret['content'])) {
                $do_callback->setValue('wfc_content', $ret['content']);
            } else {
                $do_callback->setValue('wfc_content', '');
            }

            $fileName = str_replace('.html', '', $htmlfile);
            if (isset($ret['title']) && !empty($ret['title'])) {
                $fileName = $ret['title'];
            }

            $ret = $do_callback->htmlClean($do_callback->getValue('wfc_content'), $_REQUEST['wfc_cleaningoptions']);
            if (null !== $ret) {
                $do_callback->setValue('wfc_content', $ret);
            }
            $wfc_cid = Request::getInt('wfc_cid', 0); //Wfresource\Request::doRequest($_REQUEST, 'wfc_cid', 0, 'int');

            if (empty($_REQUEST['wfc_title'])) {
                $do_callback->setValue('wfc_title', $fileName);
            } else {
                $do_callback->setValue('wfc_title', $_REQUEST['wfc_title'] . $i);
            }
            if (empty($_REQUEST['wfc_title'])) {
                $do_callback->setValue('wfc_headline', $fileName);
            } else {
                $do_callback->setValue('wfc_headline', $_REQUEST['wfc_headline'] . $i);
            }

            /**
             * * code to remove pdf files created to update them *
             */
            if ($wfc_cid > 0) {
                $pdf = new Wfresource\Pdf(); //wfp_getClass('dopdf');
                $pdf->deleteCache($wfc_cid, $_REQUEST['wfc_title']);
            }
            // /**
            // */
            $options['noreturn'] = true;
            $ret                 = call_user_func([$do_callback, 'save'], $options);
            if (false === $ret) {
                $pageHandler->getHtmlErrors(false, 6);
                // exit();
            }
            // $do_callback->setNotificationType( $wfc_cid > 0 ? 'page_modified' : 'page_new' ) ;

            ++$i;
        }
        break;
    case 'default':
    default:
//        xoops_cp_header();

        /** @var Xmf\Module\Admin $adminObject */
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));

        $menuHandler->addSubHeader(_AM_WFC_IMPORT_DSC);
        //        $menuHandler->render(6);
        $dummyHandler = $referHandler = Wfresource\Helper::getInstance()->getHandler('WfpDummy');
        $up_obj       = $dummyHandler->create();
        $up_obj->formEdit('wfp_import');
}
//xoosla_cp_footer();
require_once __DIR__ . '/admin_footer.php';
