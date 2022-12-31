<?php declare(strict_types=1);

/**
 * Name: upload.php
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
use XoopsModules\Wfresource;

require_once __DIR__ . '/admin_header.php';

$menuHandler->addHeader(_AM_WFC_UPLOADAREA);
$op = Request::getString('op', 'default'); //Wfresource\Request::doRequest($_REQUEST, 'op', 'default', 'textbox');
switch ($op) {
    case 'upload':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header(xoops_getenv('SCRIPT_NAME'), 0, $GLOBALS['xoopsSecurity']->getErrors(true));
        }
        $uploadfile = Request::getString('name', ''); //Wfresource\Request::doRequest($_FILES['uploadfile'], 'name', '', 'textbox');
        $uploadpath = Request::getString('uploadpath', ''); //Wfresource\Request::doRequest($_REQUEST, 'uploadpath', '', 'textbox');
        $rootnumber = Request::getInt('rootnumber', 0); //Wfresource\Request::doRequest($_REQUEST, 'rootnumber', 0, 'int');
        /**
         * Do checks here
         */
        if (!empty($uploadfile)) {
            if (file_exists(XOOPS_ROOT_PATH . "/${uploadpath}/${uploadfile}")) {
                xoops_cp_header();
                //                $menuHandler->render(5);
                echo sprintf(_AM_WFC_CHANIMAGEEXIST, $uploadfile);
                //xoosla_cp_footer();
                require_once __DIR__ . '/admin_footer.php';
                exit();
            }

            $allowed_mimetypes = ['text/html'];
            if (3 !== $rootnumber) {
                $allowed_mimetypes = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'];
            }
            $ret = Wfresource\Utility::uploader($allowed_mimetypes, $uploadfile, xoops_getenv('SCRIPT_NAME'), 1, $uploadpath);
            xoops_cp_header();

            //            $menuHandler->render(5);
            echo $ret;
        } else {
            xoops_cp_header();

            //            $menuHandler->render(5);
            echo _AM_WFP_FILEDOESNOTEXIST;
        }
        break;
    case 'delete':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header(xoops_getenv('SCRIPT_NAME'), 0, $GLOBALS['xoopsSecurity']->getErrors(true));
        }

        $ok          = Request::getInt('ok', 0); //Wfresource\Request::doRequest($_POST, 'ok', 0, 'int');
        $uploadpath  = Request::getString('uploadpath', ''); //Wfresource\Request::doRequest($_REQUEST, 'uploadpath', '', 'textbox');
        $channelfile = Request::getString('channelfile', ''); //Wfresource\Request::doRequest($_REQUEST, 'channelfile', '', 'textbox');
        $file        = explode('|', $channelfile);
        $channelfile = is_array($file) ? $file[0] : $file;

        if ($ok) {
            $filetodelete = XOOPS_ROOT_PATH . '/' . $uploadpath . '/' . $channelfile;
            if (file_exists($filetodelete)) {
                chmod($filetodelete, 0777);
                if (@unlink($filetodelete)) {
                    redirect_header(xoops_getenv('SCRIPT_NAME'), 1, sprintf(_AM_WFP_FILEDELETED, $channelfile));
                } else {
                    xoops_cp_header();
                    //                    echo $menuHandler->render(5);
                    echo sprintf(_AM_WFP_ERRORDELETEFILE, $channelfile);
                    //xoosla_cp_footer();
                    require_once __DIR__ . '/admin_footer.php';
                }
            }
        } else {
            xoops_cp_header();
            $menuHandler->addSubHeader(_AM_WFP_MAINAREA_DELETE_DSC);
            //            $menuHandler->render(5);
            xoops_confirm(
                [
                    'op'          => 'delete',
                    'uploadpath'  => $uploadpath,
                    'channelfile' => $channelfile,
                    'ok'          => 1,
                ],
                xoops_getenv('SCRIPT_NAME'),
                sprintf(_AM_WFP_DYRWTDICONFIRM, $channelfile),
                'Delete'
            );
        }
        break;
    case 'default':
    default:
        xoops_cp_header();

        /** @var Xmf\Module\Admin $adminObject */
        $adminObject = Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));

        $menuHandler->addSubHeader(_AM_WFC_UPLOADAREA_DSC);
        //        $menuHandler->render(5);
        //        $dummyHandler = $referHandler = wfp_getHandler('dummy');
        $dummyHandler = $referHandler = Wfresource\Helper::getInstance()->getHandler('WfpDummy');
        $up_obj       = $dummyHandler->create();
        $up_obj->formEdit('wfp_upload');
}
//xoosla_cp_footer();
require_once __DIR__ . '/admin_footer.php';
