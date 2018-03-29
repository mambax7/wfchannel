<?php namespace XoopsModules\Wfchannel;

use Xmf\Request;
use XoopsModules\Wfchannel;
use XoopsModules\Wfchannel\Common;

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------
}
