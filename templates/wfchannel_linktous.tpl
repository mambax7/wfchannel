<{if $linktous.title }>
    <div class="page_headline"><span class="itemTitle"><{$linktous.title}></span></div><{/if}>
<br>

<{if $xoops_isadmin }>
    <div class="page_adminlink"><span><{$smarty.const._MD_WFC_ADMINTASKS}></span>
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/link.php"><img class="page_image"
                                                                                src="<{xoModuleIcons16 edit.png}>"
                                                                                title="<{$smarty.const._MD_WFP_MODIFY}>"
                                                                                alt="<{$smarty.const._MD_WFP_MODIFY}>"></a>
    </div>
<{/if}>

<{if $menu_top }>
    <{include file="db:wfchannel_channellinks.tpl"}>
<{/if}>
<div style="clear: both;"></div>

<div class="itemBody">
    <{if $linktous.image.image|default:'' }>
        <div class="page_logo"><img class="page_logo_image" src="<{$linktous.image.url}>"
                                    width="<{$linktous.image.width}>" height="<{$linktous.image.height}>" name="image"
                                    id="image"
                                    title="<{$chanlink2.title}>" alt="<{$chanlink2.title}>">

            <div class="page_logo_caption"><{$linktous.caption}></div>
        </div>
    <{/if}>
    <div class="itemText"><{$linktous.content|wordwrap:200:"\n":true}></div>
</div>
<div style="clear: both;"></div>

<div id="container">
    <{if $linktous.textlink }>
        <div class="itemHead"><{$smarty.const._MD_WFC_DISPLAYTEXTLINK}></div>
        <div class="box">
            <div class="exampleText"><{$smarty.const._MD_WFC_TEXTLINKEXAMPLE}></div>
            <div class="exampleimage"><{$linktous.textlink}></div>
            <div class="codeText"><{$smarty.const._MD_WFC_DISPLAYSCRIPT}></div>
            <div class="codeTextArea"><{$linktous.textlink|escape}></div>
        </div>
    <{/if}>

    <{if $linktous.button }>
        <div class="itemHead"><{$smarty.const._MD_WFC_DISPLAYBUTTONLINK}></div>
        <div class="box">
            <div class="exampleText"><{$smarty.const._MD_WFC_BUTTONLINKEXAMPLE}></div>
            <div class="exampleimage"><{$linktous.button}></div>
            <div class="codeText"><{$smarty.const._MD_WFC_DISPLAYSCRIPT}></div>
            <div class="codeTextArea"><{$linktous.button|escape}></div>
        </div>
    <{/if}>

    <{if $linktous.logo }>
        <div class="itemHead"><{$smarty.const._MD_WFC_DISPLAYLOGOLINK}></div>
        <div class="box">
            <div class="exampleText"><{$smarty.const._MD_WFC_LOGOLINKEXAMPLE}></div>
            <div class="exampleimage"><{$linktous.logo}></div>
            <div class="codeText"><{$smarty.const._MD_WFC_DISPLAYSCRIPT}></div>
            <div class="codeTextArea"><{$linktous.logo|escape}></div>
        </div>
    <{/if}>

    <{if $linktous.banner }>
        <div class="itemHead"><{$smarty.const._MD_WFC_DISPLAYBANNERLINK}></div>
        <div class="box">
            <div class="exampleText"><{$smarty.const._MD_WFC_BANNERLINKEXAMPLE}></div>
            <div class="exampleimage"><{$linktous.banner}></div>
            <div class="codeText"><{$smarty.const._MD_WFC_DISPLAYSCRIPT}></div>
            <div class="codeTextArea"><{$linktous.banner|escape}></div>
        </div>
    <{/if}>

    <{if $linktous.microbutton }>
        <div class="itemHead"><{$smarty.const._MD_WFC_DISPLAYMICROLINK}></div>
        <div class="outerdiv">
            <div class="exampleText"><{$smarty.const._MD_WFC_MIRCOLINKEXAMPLE}></div>
            <div class="exampleimage"><{$linktous.microbutton}></div>
            <div class="codeText"><{$smarty.const._MD_WFC_DISPLAYSCRIPT}></div>
            <div style="text-align: center;">
                <div class="codeTextArea"><{$linktous.microbutton|escape}></div>
            </div>
        </div>
    <{/if}>

    <div id="box6">
        <{if $linktous.newsfeed }>
            <div class="itemHead"><{$smarty.const._MD_WFC_DISPLAYNEWSLINK}></div>
            <div class="rssicon"><img src='<{$xoops_url}>/modules/<{$smarty.const._MODULE_DIR}>/images/rss.gif'
                                      name='image5' id='image5' alt='<{$linktous.sitename|default:''}>'></div>
            <div class="codeText"><{$lang_displaynewsrss|default:''}></div>
            <div class="newsfeed"><b><{$smarty.const._MD_WFC_NEWSFEEDLINKEXAMPLE}></b> <{$xoops_url}>/backend.php</div>
        <{/if}>
        <{if $linktous.newsfeedjs|default:'' }>
            <div class="newsfeed"><b><{$smarty.const._MD_WFC_NEWSFEEDJSLINKEXAMPLE}></b> <{$xoops_url}>
                /modules/wfchannel/backendjs.php
            </div>
            <!--<div class="displayjava"><{$smarty.const._MD_WFC_DISPLAYJSNEWSRSSLINK}></div>-->
            <div class="codeText"><{$smarty.const._MD_WFC_DISPLAYSCRIPT}></div>
            <div class="codeTextArea"><label>
                    <textarea name='backend' cols='70' rows='4'>&lt;script type=&quot;text/javascript&quot; src=&quot;&lt;{$xoops_url}&gt;/modules/&lt;{$xoops_dirname}&gt;/backendjs.php&quot;&gt;</textarea>
                </label>
            </div>
        <{/if}>
    </div>
</div>

<{if $menu_bottom }>
    <{include file="db:wfchannel_channellinks.tpl"}>
<{/if}>

<div align="center" class="copyright"><{$smarty.const._MD_WFC_COPYRIGHTNOTICE}></div>

<div class="copyright"><{$copyright}></div>
