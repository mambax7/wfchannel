<?php
include 'admin_header.php';
$menu_handler->addHeader( _MA_AD_CONTUSAREA );
$_handler = &wfp_gethandler( 'contactus', _MODULE_DIR, _MODULE_CLASS );

$op = wfp_cleanRequestVars( $_REQUEST, 'op', 'edit', XOBJ_DTYPE_TXTBOX );
$options = null;
$do_callback = wfp_getObjectCallback( $_handler );
$menu = 4;
switch ( $op ) {
    case 'edit':
        $menu_handler->addSubHeader( _MA_AD_CONTUSAREA_DSC );
        $do_callback->setId( 1 );
        $do_callback->setMenu( $menu );
        if ( !call_user_func( array( $do_callback, $op ), $options ) ) {
            $_handler->getHtmlErrors( false, $menu );
        }
        break;

    case 'save':
        unset( $_SESSION['wfc_channel'] );
        $_REQUEST['dohtml'] = wfp_cleanRequestVars( $_REQUEST, 'dohtml', '0', XOBJ_DTYPE_INT );
        $_REQUEST['doxcode'] = wfp_cleanRequestVars( $_REQUEST, 'doxcode', '0', XOBJ_DTYPE_INT );
        $_REQUEST['dosmiley'] = wfp_cleanRequestVars( $_REQUEST, 'dosmiley', '0', XOBJ_DTYPE_INT );
        $_REQUEST['doimage'] = wfp_cleanRequestVars( $_REQUEST, 'doimage', '0', XOBJ_DTYPE_INT );
        $_REQUEST['dobr'] = wfp_cleanRequestVars( $_REQUEST, 'dobr', '0', XOBJ_DTYPE_INT );
        if ( !call_user_func( array( $do_callback, $op ), $options ) ) {
            $_handler->getHtmlErrors();
        }
        break;
}
wfp_adminFooter();

?>