<?php
/**
 * Name: upload.php
 * Description:
 *
 * @package    : Xoosla Modules
 * @Module     :
 * @subpackage :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */
include_once __DIR__ . '/admin_header.php';

$menu_handler->addHeader(_AM_WFC_UPLOADAREA);
$op = wfp_Request::doRequest($_REQUEST, 'op', 'default', 'textbox');
switch ($op) {
    case 'upload':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header(xoops_getenv('PHP_SELF'), 0, $GLOBALS['xoopsSecurity']->getErrors(true));
        }
        $uploadfile = wfp_Request::doRequest($_FILES['uploadfile'], 'name', '', 'textbox');
        $uploadpath = wfp_Request::doRequest($_REQUEST, 'uploadpath', '', 'textbox');
        $rootnumber = wfp_Request::doRequest($_REQUEST, 'rootnumber', 0, 'int');
        /**
         * Do checks here
         */
        if (!empty($uploadfile)) {
            if (file_exists(XOOPS_ROOT_PATH . "/${uploadpath}/${uploadfile}")) {
                xoops_cp_header();
                //                $menu_handler->render(5);
                echo sprintf(_AM_WFC_CHANIMAGEEXIST, $uploadfile);
                xoosla_cp_footer();
                exit();
            }

            $allowed_mimetypes = array('text/html');
            if ($rootnumber !== 3) {
                $allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png');
            }
            $ret = wfp_uploader($allowed_mimetypes, $uploadfile, xoops_getenv('PHP_SELF'), 1, $uploadpath);
            xoops_cp_header();
            //            $menu_handler->render(5);
            echo $ret;
        } else {
            xoops_cp_header();
            //            $menu_handler->render(5);
            echo _AM_WFP_FILEDOESNOTEXIST;
        }
        break;

    case 'delete':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header(xoops_getenv('PHP_SELF'), 0, $GLOBALS['xoopsSecurity']->getErrors(true));
        }

        $ok          = wfp_Request::doRequest($_POST, 'ok', 0, 'int');
        $uploadpath  = wfp_Request::doRequest($_REQUEST, 'uploadpath', '', 'textbox');
        $channelfile = wfp_Request::doRequest($_REQUEST, 'channelfile', '', 'textbox');
        $file        = explode('|', $channelfile);
        $channelfile = is_array($file) ? $file[0] : $file;

        if ($ok) {
            $filetodelete = XOOPS_ROOT_PATH . '/' . $uploadpath . '/' . $channelfile;
            if (file_exists($filetodelete)) {
                chmod($filetodelete, 0777);
                if (@unlink($filetodelete)) {
                    redirect_header(xoops_getenv('PHP_SELF'), 1, sprintf(_AM_WFP_FILEDELETED, $channelfile));
                } else {
                    xoops_cp_header();
                    //                    echo $menu_handler->render(5);
                    echo sprintf(_AM_WFP_ERRORDELETEFILE, $channelfile);
                    xoosla_cp_footer();
                }
            }
        } else {
            xoops_cp_header();
            $menu_handler->addSubHeader(_AM_WFP_MAINAREA_DELETE_DSC);
            //            $menu_handler->render(5);
            xoops_confirm(array(
                              'op'          => 'delete',
                              'uploadpath'  => $uploadpath,
                              'channelfile' => $channelfile,
                              'ok'          => 1
                          ), xoops_getenv('PHP_SELF'), sprintf(_AM_WFP_DYRWTDICONFIRM, $channelfile), 'Delete');
        }
        break;

    case 'default':
    default:
        xoops_cp_header();
        $menu_handler->addSubHeader(_AM_WFC_UPLOADAREA_DSC);
        //        $menu_handler->render(5);
        $dummy_handler = $refer_handler = &wfp_getHandler('dummy');
        $up_obj        = $dummy_handler->create();
        $up_obj->formEdit('wfp_upload');
}
xoosla_cp_footer();
