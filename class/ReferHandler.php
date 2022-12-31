<?php declare(strict_types=1);

namespace XoopsModules\Wfchannel;

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
use const ENT_HTML5;
use function md5;
use function sha1;
use Xmf\Request;
use XoopsModules\Wfchannel;
use XoopsModules\Wfresource;

//wfp_getObjectHandler();

\define('SALT_LENGTH', 9);

/**
 * WfchannelReferHandler
 *
 * @author    John
 * @copyright Copyright (c) 2007
 */
class ReferHandler extends Wfresource\WfpObjectHandler
{
    /**
     * WfchannelPageHandler::XoopsCategoryHandler()
     *
     * @param mixed $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        $this->db = $db;
        parent::__construct($db, 'wfcrefer', Refer::class, 'wfcr_id', 'wfcr_title', 'refer_read');
    }

    /**
     * ReferHandler::generateHash()
     *
     * @param mixed $plainText
     * @param mixed $salt
     */
    public function generateHash($plainText, $salt = null): string
    {
        if (null === $salt) {
            $salt = mb_substr(md5((string)\uniqid(\mt_rand(), true)), 0, \SALT_LENGTH);
        } else {
            $salt = mb_substr($salt, 0, \SALT_LENGTH);
        }

        return $salt . sha1($salt . $plainText);
    }

    /**
     * ReferHandler::doBanned()
     */
    public function doBanned(): void
    {
        $bannedip = \explode('|', Wfresource\Utility::getModuleOption('banned'));
        if (\count($bannedip) > 0) {
            $refersHandler = new Wfchannel\RefersHandler($this->db); //wfp_getHandler('refers', _MODULE_DIR, _MODULE_CLASS);
            $ip            = $refersHandler->getIP();
            if (\in_array($ip, $bannedip, true)) {
                $GLOBALS['xoopsOption']['template_main'] = 'wfchannel_banned.tpl';
                require_once XOOPS_ROOT_PATH . '/header.php';
                require_once XOOPS_ROOT_PATH . '/footer.php';
                exit();
            }
        }
    }

    /**
     * ReferHandler::refersend()
     * @return string
     */
    public function refersend(): ?string
    {
        global $xoopsConfig, $xoopsUser, $referHandler;

        $uname   = \Xmf\Request::getString('uname', ''); //Wfresource\Request::doRequest($_REQUEST, 'uname', '', 'textbox');
        $runame  = \Xmf\Request::getString('runame', ''); //Wfresource\Request::doRequest($_REQUEST, 'runame', '', 'textbox');
        $message = \Xmf\Request::getString('message', ''); //Wfresource\Request::doRequest($_REQUEST, 'message', '', 'textbox');

        $remail = Wfresource\Request::doValidate($_REQUEST['remail'], 'email');
        $email  = Wfresource\Request::doValidate($_REQUEST['email'], 'email');

        if (!$remail || !$email) {
            return \_MD_WFC_EMAILERROR_TEXT;
        }

        require_once XOOPS_ROOT_PATH . '/class/xoopsmailer.php';
        $xoopsMailer = \xoops_getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/mail_template');
        $xoopsMailer->setTemplate('refer.tpl');
        $xoopsMailer->assign('SITENAME', $GLOBALS['xoopsConfig']['sitename']);
        $xoopsMailer->assign('SITEURL', XOOPS_URL . '/');
        $xoopsMailer->assign('TITLE', \_MD_WFC_MESSAGETITLE);
        $xoopsMailer->assign('SUSER', Wfresource\Utility::stripslashes($uname));
        $xoopsMailer->assign('RUSER', Wfresource\Utility::stripslashes($runame));
        $xoopsMailer->assign('MESSAGE', \htmlspecialchars(Wfresource\Utility::stripslashes($message), \ENT_QUOTES | ENT_HTML5));
        $xoopsMailer->assign('VISIT', \_MD_WFC_VISIT);
        $xoopsMailer->setToEmails(Wfresource\Utility::stripslashes($remail));
        $xoopsMailer->setFromEmail(Wfresource\Utility::stripslashes($email));
        $xoopsMailer->setFromName(Wfresource\Utility::stripslashes($uname));
        $xoopsMailer->setSubject(Wfresource\Utility::stripslashes($uname) . ' ' . \_MD_WFC_MESSAGESUBECT);
        if (!$xoopsMailer->send()) {
            return \_MD_WFC_EMAILSENTWITHERRORS;
        }
        $refersHandler = new Wfchannel\RefersHandler($db); //wfp_getHandler('refers', _MODULE_DIR, _MODULE_CLASS);
        $refersHandler->setEmailSendCount();
        $refer_obj = $refersHandler->create();
        $refer_obj->setVar('wfcr_username', $uname);
        if (\is_object($GLOBALS['xoopsUser'])) {
            $refer_obj->setVar('wfcr_uid', $GLOBALS['xoopsUser']->getVar('uid'));
        }
        $refer_obj->setVar('wfcr_referurl', Request::getString('HTTP_REFERER', '', 'SERVER'));
        $refer_obj->setVar('wfcr_ip', $refersHandler->getIP());
        $refer_obj->setVar('wfcr_date', \time());
        $refersHandler->insert($refer_obj, false);
        \redirect_header('index.php', 1, \_MD_WFC_EMAILSENT);
    }

    /**
     * ReferHandler::displayErrors()
     */
    public function displayErrors(...$args): void
    {
        require_once XOOPS_ROOT_PATH . '/header.php';
        $ret    = '<h3>' . _MD_WFC_ERRORS . '</h3>';
//        $argues = \func_get_args();
        if (1 == \func_num_args()) {
            $ret .= $argues['0'];
        }
        $ret .= '<div style="padding-top: 12px;"><a href=\'javascript:history.go(-1)\'>[ ' . \_MD_WFC_GOBACKBUTTON . ' ]</a></div>';
        echo $ret;
        require_once XOOPS_ROOT_PATH . '/footer.php';
        exit();
    }
}
