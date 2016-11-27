<?php
// Hacked from backend.php by lykoszine@yahoo.co.uk
// Uses the following CSS classes:
// rss_title
// rss_body
// rss_footer
$filename = 'cache/backendjs.txt'; //File to read/write
$timespan = 3600; //1 hours (if the file is more recent than this, it will not be updated)
include_once __DIR__ . '/../../mainfile.php';
$fd = fopen($filename, 'rb');
if ($fd and (time() - filemtime($filename) < $timespan)) {
    $contents = fread($fd, filesize($filename));
    echo $contents;
    fclose($fd);
} else {
    fclose($fd);
    $sql    = 'SELECT storyid, title FROM ' . $xoopsDB->prefix('news_stories') . ' WHERE published>0 AND published<' . time() . ' ORDER BY published DESC';
    $result = $xoopsDB->query($sql, 10, 0);
    if (!$result) {
        echo 'An error occured';
    } else {
        $fd   = fopen($filename, 'w+b');
        $temp = "<script language='Javascript'>";
        $temp .= "document.write('<div class=\"rss_title\">";
        $temp .= "<a href=\"" . XOOPS_URL . "\">" . $xoopsConfig['sitename'] . "</a> News<br></div>');\n";

        while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
            $myrow = str_replace('(', '-', $myrow);
            $myrow = str_replace(')', '-', $myrow);
            $myrow = str_replace("'", '', $myrow);
            $temp .= "document.write('<LI><span class=\"rss_body\"><A HREF=\"" . XOOPS_URL . '/modules/news/article.php?storyid=' . $myrow['storyid'] . "\" target=blank>";
            $temp .= $myrow['title'] . "</a></span><br>');\n";
        }
        $t = formatTimestamp(time(), 'm', '' . $xoopsConfig['server_TZ'] . '');
        $temp .= "document.write('<div class=\"rss_footer\">Updated : $t</div>');";
    }
    $temp .= '</script>';
    echo $temp;
    fwrite($fd, $temp, strlen($temp));
    fclose($fd);
}
