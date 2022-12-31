<?php declare(strict_types=1);

/**
 * Module: WF-Channel
 * Version: v1.0.5
 * Release Date: 03 Jan 2004
 * Author: Catzwolf
 * Licence: GNU
 */

use Xmf\Request;

require_once __DIR__ . '/admin_header.php';

$op = '';

if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        ${$k} = $v;
    }
}

if (isset($_GET)) {
    foreach ($_GET as $k => $v) {
        ${$k} = $v;
    }
}

$op = Request::getString('op', Request::getCmd('op', '', 'POST'), 'GET');

switch ($op) {
    case 'reorder':
        global $orders, $cat;
        $ordersCount = count($orders);
        for ($i = 0; $i < $ordersCount; ++$i) {
            $xoopsDB->queryF('update ' . $xoopsDB->prefix('wfschannel') . ' set weight = ' . $orders[$i] . " WHERE CID=$cat[$i]");
        }
        redirect_header('reorder.php', 1, _AM_REORDERCHANNEL);

        break;
    case 'default':
    default:
        xoops_cp_header();
        global $xoopsConfig, $xoopsModule, $_GET;
        //        wfc_adminmenu(_AM_CHANADMIN);

        $orders = [];
        $cat    = [];

        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_REORDERADMIN . '</legend>';
        echo "<div style='padding: 8px;'>" . _AM_REORDERINTRO . '</div>';

        echo "<form name='reorder' METHOD='post'>";
        echo "<table border='0' width='100%' cellpadding = '2' cellspacing ='1' class = 'outer'>";
        echo '<tr>';
        echo "<td class = bg3 align='center' width=3% height =16 ><b>" . _AM_REORDERID . '</b>';
        echo "</td><td class = bg3 align='left' width=30%><b>" . _AM_REORDERTITLE . '</b>';
        echo "</td><td class = bg3 align='center' width=5%><b>" . _AM_REORDERWEIGHT . '</b>';
        echo '</td></tr>';

        $result = $xoopsDB->query('SELECT CID, pagetitle, weight FROM ' . $xoopsDB->prefix('wfschannel') . ' ORDER BY weight');
        while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
            echo '<tr>';
            echo "<td align='center' class = head>" . $myrow['CID'] . '</td>';
            echo "<input type='hidden' name='cat[]' value='" . $myrow['CID'] . "'>";
            echo "<td align='left' nowrap='nowrap' class = even>" . $myrow['pagetitle'] . '</td>';
            echo "<td align='center' class = even>";
            echo "<input type='text' name='orders[]' value='" . $myrow['weight'] . "' size='5' maxlenght='5'>";
            echo '</td>';
            echo '</tr>';
        }
        echo "<tr><td class='even' align='center' colspan='6'>";
        echo "<input type='hidden' name='op' value=reorder>";
        echo "<input type='submit' name='submit' value='" . _SUBMIT . "'>";

        echo '</td></tr>';
        echo '</table>';
        echo '</form>';
        echo '</fieldset>';
        break;
}
xoops_cp_footer();
