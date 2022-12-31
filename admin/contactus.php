<?php declare(strict_types=1);

use XoopsModules\Wfchannel;

require_once __DIR__ . '/admin_header.php';
$menuHandler->addHeader(_AM_AD_CONTUSAREA);
$contactusHandler = new Wfchannel\ContactusHandler($db); //wfp_getHandler('contactus', _MODULE_DIR, _MODULE_CLASS);

$op          = wfp_cleanRequestVars($_REQUEST, 'op', 'edit', XOBJ_DTYPE_TXTBOX);
$options     = null;
$do_callback = Wfresource\Utility::getObjectCallback($contactusHandler);
$menu        = 4;
switch ($op) {
    case 'edit':
        $menuHandler->addSubHeader(_AM_AD_CONTUSAREA_DSC);
        $do_callback->setId(1);
        $do_callback->setMenu($menu);
        if (!call_user_func([$do_callback, $op], $options)) {
            $contactusHandler->getHtmlErrors(false, $menu);
        }
        break;
    case 'save':
        unset($_SESSION['wfc_channel']);
        $_REQUEST['dohtml']   = wfp_cleanRequestVars($_REQUEST, 'dohtml', '0', XOBJ_DTYPE_INT);
        $_REQUEST['doxcode']  = wfp_cleanRequestVars($_REQUEST, 'doxcode', '0', XOBJ_DTYPE_INT);
        $_REQUEST['dosmiley'] = wfp_cleanRequestVars($_REQUEST, 'dosmiley', '0', XOBJ_DTYPE_INT);
        $_REQUEST['doimage']  = wfp_cleanRequestVars($_REQUEST, 'doimage', '0', XOBJ_DTYPE_INT);
        $_REQUEST['dobr']     = wfp_cleanRequestVars($_REQUEST, 'dobr', '0', XOBJ_DTYPE_INT);
        if (!call_user_func([$do_callback, $op], $options)) {
            $contactusHandler->getHtmlErrors();
        }
        break;
}
wfp_adminFooter();
