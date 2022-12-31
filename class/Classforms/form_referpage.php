<?php declare(strict_types=1);

namespace XoopsModules\Wfchannel\Classforms;

/**
 * Name: form_wfc_refer.php
 * Description:
 *
 * @Module     :
 * @since      : v1.0.0
 * @author     John Neill <catzwolf@xoosla.com>
 * @copyright  : Copyright (C) 2009 Xoosla. All rights reserved.
 * @license    : GNU/LGPL, see docs/license.php
 */
\defined('XOOPS_ROOT_PATH') || exit('Restricted access');

global $xoopsTpl, $referHandler;

\xoops_load('XoopsForm');
$form = new \XoopsThemeForm('', 'refer_form', 'index.php', 'post', true);
$form->setExtra('enctype="multipart/form-data"');
$form->addElement(new \XoopsFormText(\_MD_WFC_SENDERNAME, 'uname', 40, 255, $this->getVar('uname')), true);
$form->addElement(new \XoopsFormText(\_MD_WFC_SENDEREMAIL, 'email', 40, 255, $this->getVar('emailaddy')), true);
$form->addElement(new \XoopsFormText(\_MD_WFC_RECPINAME, 'runame', 40, 255), true);
$form->addElement(new \XoopsFormText(\_MD_WFC_RECPIEMAIL, 'remail', 40, 255), true);
if ($this->getVar('wfsr_ublurb')) {
    $form->addElement(new \XoopsFormTextArea(\_MD_WFC_CAPTCHA, 'message', $this->getVar('wfcr_dblurb')), false);
} else {
    $form->addElement(new \XoopsFormHidden('message', $this->getVar('wfcr_dblurb')));
}

\xoops_load('XoopsCaptcha');
$xoopsCaptcha = \XoopsCaptcha::getInstance();

//var_dump($xoopsCaptcha->isActive());

if ($xoopsCaptcha->isActive()) {
    $form->addElement(new \XoopsFormCaptcha(\_MD_WFC_CAPTCHA, 'captcha'), true);
}
$form->addElement(new \XoopsFormHidden('op', 'refersend'));
$form->addElement(new \XoopsFormButtonTray('submit', _SUBMIT));
$form->assign($xoopsTpl);
