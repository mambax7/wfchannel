<?php declare(strict_types=1);

// ------------------------------------------------------------------------ //
// WF-Channel - WF-Projects                                                 //
// Copyright (c) 2007 WF-Channel                                            //
// //
// Authors:                                                                 //
// John Neill ( AKA Catzwolf )                                              //
// //
// URL: https://catzwolf.x10hosting.com/                                     //
// Project: WF-Projects                                                     //
// -------------------------------------------------------------------------//

defined('XOOPS_ROOT_PATH') || exit('You do not have permission to access this file!');

if (!isset($GLOBALS['xoopsConfig']['language'])) {
    $GLOBALS['xoopsConfig']['language'] = 'english';
}

$moduleDirName = \basename(\dirname(__DIR__));

define('_MODULE_DIR', $moduleDirName);
define('_WFC_MODULE_PATH', XOOPS_ROOT_PATH . '/modules/' . $moduleDirName);
define('_MODULE_CLASS', 'wfc_');

/**
 * wfc_CheckResource()
 *
 * @param $upgrade
 * @return bool
 */
function wfc_CheckResource($upgrade)
{
    global $xoopsUserIsAdmin, $xoopsConfig, $xoopsUser;

    /** @var \XoopsModuleHandler $moduleHandler */
    $moduleHandler = xoops_getHandler('module');
    $wmodule       = $moduleHandler->getByDirname(_MODULE_DIR);

    /**
     * WR-Resource
     */
    $wf_resource = $moduleHandler->getByDirname('wfresource');
    if (is_object($wf_resource)) {
        $wfr_installed = (int)$wf_resource->getVar('version');
        $wfr_actual    = (int)$wf_resource->getInfo('version');
        /**
         * WF-Channel
         */
    }
    $wmodule      = $moduleHandler->getByDirname(_MODULE_DIR);
    $wfc_requires = ($wmodule->getInfo('requires'));

    $ret = 0;
    if (!is_object($wf_resource)) {
        $ret = 1;
    } elseif (0 === $wf_resource->getVar('isactive')) {
        $ret = 2;
    } elseif ($wfr_installed < $wfc_requires) {
        $ret = 3;
    }

    if (0 != $ret) {
        if (true === $upgrade) {
            return false;
        }
        $text = '';
        require_once XOOPS_ROOT_PATH . '/header.php';
        require_once XOOPS_ROOT_PATH . '/modules/' . $wmodule->getVar('dirname') . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/errors.php';
        $wfc_requires = '1.04';
        switch ($ret) {
            case 1:
                $text = ($xoopsUserIsAdmin) ? sprintf(_MD_WFC_ERROR_MISSING_MODULE, $wmodule->getVar('name'), $wfc_requires) : _MD_WFC_TECHISSUES;
                break;
            case 2:
                $text = ($xoopsUserIsAdmin) ? sprintf(_MD_WFC_ERROR_NOTACTIVE, $wfc_requires) : _MD_WFC_TECHISSUES;
                break;
            case 3:
                $text = ($xoopsUserIsAdmin) ? sprintf(_MD_WFC_ERROR_NOTUPDATE, $wmodule->getVar('name'), $wfc_requires) : _MD_WFC_TECHISSUES;
                break;
        } // switch
        echo $text;
        require_once XOOPS_ROOT_PATH . '/footer.php';
        exit();

        return (true === $isUpgrade) ? true : wfc_DisplayUserError();
    }

    return true;
}

if (empty($upgrade)) {
    $upgrade = false;
}

//TODO convert version check to Semantic

//$result = wfc_CheckResource($upgrade);
//if ($result) {
//    xoops_loadLanguage('admin', 'wfresource');
//    xoops_loadLanguage('main', 'wfresource');
//
//    if (file_exists($file = XOOPS_ROOT_PATH . '/modules/wfresource/include/functions.php')) {
//        require_once $file;
//    }
//}

/**
 * @param null $name
 * @param null $def
 * @param bool $strict
 * @param int  $lengthcheck
 * @return array|false|int|string|null
 */
function wfp_cleanRequestVars(&$array, $name = null, $def = null, $strict = false, $lengthcheck = 15)
{
    /**
     * Sanitise $_request for further use.  This method gives more control and security.
     * Method is more for functionality rather than beauty at the moment, will correct later.
     */
    unset($array['usercookie'], $array['PHPSESSID']);

    if (is_array($array) && null === $name) {
        $globals = [];
        foreach (array_keys($array) as $k) {
            $value = strip_tags(trim($array[$k]));
            if (mb_strlen($value >= $lengthcheck)) {
                return null;
            }

            if (ctype_digit($value)) {
                $value = (int)$value;
            } else {
                if ($strict) {
                    $value = preg_replace('/\W/', '', trim($value));
                }
                $value = \mb_strtolower((string)$value);
            }
            $globals[$k] = $value;
        }

        return $globals;
    }

    if (!isset($array[$name]) || !array_key_exists($name, $array)) {
        return $def;
    }
    $value = strip_tags(trim($array[$name]));

    if (ctype_digit($value)) {
        $value = (int)$value;
    } else {
        if ($strict) {
            $value = preg_replace('/\W/', '', trim($value));
        }
        $value = \mb_strtolower((string)$value);
    }

    return $value;
}
