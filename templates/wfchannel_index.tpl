<div class="wrapper">
    <div class="page_icons">
        <{if $page_info.icons.rss }><a target="_blank"
                                       href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php?act=rss" rel="nofollow"
                                       title="<{$smarty.const._MD_WFP_RSS_ICON}>"><img
                    class="page_image" src="<{$xoops_url}>/modules/<{$icon_dirname}>/assets/images/icon/content_rss.png"
                    title="<{$smarty.const._MD_WFP_RSS_ICON}>" alt="<{$smarty.const._MD_WFP_RSS_ICON}>"></a><{/if}>
        <{if $page_info.icons.print }><a target="_blank"
                                         href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php?cid=<{$page_info.id}>&amp;act=print"
                                         rel="nofollow"
                                         title="<{$smarty.const._MD_WFP_PRINT_ICON}>"><img class="page_image"
                                                                                           src="<{$xoops_url}>/modules/<{$icon_dirname}>/assets/images/icon/content_print.png"
                                                                                           title="<{$smarty.const._MD_WFP_PRINT_ICON}>"
                                                                                           alt="<{$smarty.const._MD_WFP_PRINT_ICON}>">
            </a><{/if}>
        <{if $page_info.icons.pdf }><a target="_blank"
                                       href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php?cid=<{$page_info.id}>&amp;act=pdf"
                                       rel="nofollow"
                                       title="<{$smarty.const._MD_WFP_PDF_ICON}>"><img class="page_image"
                                                                                       src="<{$xoops_url}>/modules/<{$icon_dirname}>/assets/images/icon/content_pdf.png"
                                                                                       title="<{$smarty.const._MD_WFP_PDF_ICON}>"
                                                                                       alt="<{$smarty.const._MD_WFP_PDF_ICON}>">
            </a><{/if}>
        <{if $page_info.icons.email }><a target="_top" href="<{$page_info.maillink}>"
                                         title="<{$smarty.const._MD_WFP_EMAIL_ICON}>" rel="nofollow"><img
                    class="page_image"
                    src="<{$xoops_url}>/modules/<{$icon_dirname}>/assets/images/icon/content_email.png"
                    border="0"
                    alt="<{$smarty.const._MD_WFP_EMAIL_ICON}>">
            </a><{/if}>
        <{if $page_info.icons.bookmark }><a href="#" rel="sidebar"
                                            onclick="if(document.all &amp;&amp; !window.opera){ window.external.AddFavorite(location.href, document.title); return false; }else{ this.title = document.title; }"
                                            title="bookmark this page"><img class="page_image"
                                                                            src="<{$xoops_url}>/modules/<{$icon_dirname}>/images/icon/content_bookmark.png"
                                                                            title="<{$smarty.const._MD_WFP_BOOKMARK_ICON}>"
                                                                            alt="<{$smarty.const._MD_WFP_BOOKMARK_ICON}>">
            </a><{/if}>
    </div>
    <{if $page_info.title }>
        <div class="page_headline"><span class="itemTitle"><{$page_info.title}></span></div>
    <{/if}>
    <{if $page_info.author }>
        <div class="itemPoster"><{$smarty.const._MD_WFP_AUTHOR}>: <{$page_info.author}></div>
    <{/if}>
    <{if $page_info.published }>
        <div class="itemPostDate"><{$smarty.const._MD_WFP_PUBLISHED}>: <{$page_info.published}></div>
    <{/if}>
    <{if $page_info.counter }>
        <div class="itemPostDate"><{$page_info.counter}></div>
    <{/if}>
</div>

<{if $xoops_isadmin AND $page_info.id > 0  }>
    <div class="page_adminlink"><span><{$smarty.const._MD_WFC_ADMINTASKS}></span>
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=edit&amp;wfc_cid=<{$page_info.id}>"><img
                    class="page_image" src="<{xoModuleIcons16 edit.png}>"
                    title="<{$smarty.const._MD_WFP_MODIFY}>" alt="<{$smarty.const._MD_WFP_MODIFY}>"></a>
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=delete&amp;wfc_cid=<{$page_info.id}>"><img
                    class="page_image" src="<{xoModuleIcons16 delete.png}>"
                    title="<{$smarty.const._MD_WFP_DELETE}>"
                    alt="<{$smarty.const._MD_WFP_DELETE}>"></a>
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/main.php?op=duplicate&amp;wfc_cid=<{$page_info.id}>"><img
                    class="page_image" src="<{xoModuleIcons16 editcopy.png}>"
                    title="<{$smarty.const._MD_WFP_DUPLICATE}>"
                    alt="<{$smarty.const._MD_WFP_DUPLICATE}>"></a>
    </div>
<{/if}>

<{if $wfc_tag}>
    <div class="page_tags"><{include file="db:tag_bar.tpl"}></div>
<{/if}>

<{if $menu_top }>
    <{include file="db:wfchannel_channellinks.tpl"}>
<{/if}>

<{if $page_info.pagenav }>
    <div class=""><{$page_info.pagenav}></div><{/if}>

<div style="clear: both;"></div>
<div class="itemBody">
    <{if !empty($page_info.image.image) }>
        <div class="page_logo"><img class="page_logo_image" src="<{$page_info.image.url}>"
                                    width="<{$page_info.image.width}>" height="<{$page_info.image.height}>" name="image"
                                    id="image"
                                    title="<{$chanlink2.title}>" alt="<{$chanlink2.title}>">

            <div class="page_logo_caption"><{$page_info.caption}></div>
        </div>
    <{/if}>
    <div class="itemText"><{$page_info.content|wordwrap:200:"\n":true}></div>
</div>
<div style="clear: both;"></div>

<{if $page_info.pagenav|default:''}>
    <div class="page_navigation"><{$page_info.pagenav}></div><{/if}>

<{if $links|default:''}>
    <div class="page_previousnext">
        <{if $links.previous }>
            <div style="float: left;">

                <a href="<{$links.previous.link}>"><img style="vertical-align: middle;" src="assets/images/previous.gif"
                                                        title="<{$smarty.const._MD_WFP_PREVIOUSITEM}>"
                                                        alt="<{$smarty.const._MD_WFP_PREVIOUSITEM}>">&nbsp;<{$links.previous.title}>
                </a>
            </div>
        <{/if}>
        <{if $links.next}>
            <div style="float: right;">

                <a href="<{$links.next.link}>"><{$links.next.title}>&nbsp;<img style="vertical-align: middle;"
                                                                               src="assets/images/next.gif"
                                                                               title="<{$smarty.const._MD_WFP_NEXTITEM}>"
                                                                               alt="<{$smarty.const._MD_WFP_NEXTITEM}>"></a>
            </div>
        <{/if}>
    </div>
    <div style="clear: both;"></div>
<{/if}>

<{if $related|default:''}>
    <h3><{$smarty.const._MD_WFP_RELATEDLINKS}></h3>
    <div class="page_related">
        <ul>
            <{foreach item=related from=$related}>
                <li>
                    <a class="page_links"
                       href="<{$xoops_url}>/modules/<{$xoops_dirname}>/index.php?cid=<{$related.link}>"><{$related.title}></a> <{$related.time}> <{$related.uid}>
                </li>
            <{/foreach}>
        </ul>
    </div>
<{/if}>

<{if $menu_bottom }>
    <{include file="db:wfchannel_channellinks.tpl"}>
<{/if}>

<{if $page_info.bookmarks }>
    <div class="page_bookmarkstext"><{$smarty.const._MD_WFP_SEND}></div>
    <div class="page_bookmarks"><{$page_info.bookmarks}></div>
<{/if}>

<div class="copyright"><{$copyright}></div>

<{if $com_rule|default:0 != 0}>
    <div class="page_commentcount"><{$smarty.const._MD_WFP_COMMENTCOUNTS}>: <{$wfc_comments}></div>
    <div class="page_comments"><{$commentsnav}></div>
    <div class="page_commentsbox">
        <!-- start comments loop -->
    <{if $comment_mode|default:'' == "flat"}>
        <{include file="db:system_comments_flat.tpl"}>
    <{elseif $comment_mode|default:'' == "thread"}>
        <{include file="db:system_comments_thread.tpl"}>
    <{elseif $comment_mode|default:'' == "nest"}>
            <{include file="db:system_comments_nest.tpl"}>
        <{/if}>
        <!-- end comments loop -->
    </div>
    <div class="page_commentstext"><{$lang_notice}></div>
    <!-- Start topic loop -->
<{/if}>

<{include file='db:system_notification_select.tpl'}>
