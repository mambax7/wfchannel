<{if $refer.title}>
    <div class="page_headline"><span class="itemTitle"><{$refer.title}></span></div><{/if}>
<br>

<{if $xoops_isadmin }>
    <div class="page_adminlink"><span><{$smarty.const._MD_WFC_ADMINTASKS}></span>
        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/refer.php"><img class="page_image"
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
    <{if !empty($refer.image.url) }>
        <div class="page_logo"><img class="page_logo_image" src="<{$refer.image.url}>" width="<{$refer.image.width}>"
                                    height="<{$refer.image.height}>" name="image" id="image" title="<{$refer.title}>"
                                    alt="<{$refer.title}>"></div>
    <{/if}>
    <div class="itemText"><{$refer.content}></div>
</div>
<div style="clear: both;"></div>

<form id="<{$refer_form.name}>" name="<{$refer_form.name}>" action="<{$refer_form.action}>"
      method="<{$refer_form.method}>" <{$refer_form.extra}> >
    <table id="refer-form-<{$refer_form.name}>" cellspacing="1" class="outer">
        <{foreach item=element from=$refer_form.elements}>
<{*            <{if !$element.hidden}>*}>
            <{if empty($element.hidden)}>
                <tr>
                    <td class="head">
                        <div class='xoops-form-element-caption<{if !empty($element.required)}>-required<{/if}>'>
                            <span class='caption-text'><{if !empty($element.caption)}><{$element.caption}><{/if}></span>
                            <span class='caption-marker'>*</span>
                        </div>
                        <{if !empty($element.description) }>
                            <div class='xoops-form-element-help'><{$element.description}></div>
                        <{/if}>
                    </td>
                    <td class="<{cycle values='odd, even'}>">
                        <{$element.body}>
                    </td>
                </tr>
            <{/if}>
        <{/foreach}>
    </table>
    <{foreach item=element from=$refer_form.elements}>
        <{if !empty($element.hidden)}>
            <{$element.body}>
        <{/if}>
    <{/foreach}>
</form>
<{$refer_form.javascript}>

<div style="clear: both;">&nbsp;</div>

<{if !empty($referfriend.privacy_statement)}>
    <div style="padding-top: 6px; width: 70%; margin-left: auto; margin-right: auto;"><span
                style="text-align: center;"><{$referfriend.privacy_statement}></span></div>
    <br>
<{/if}>

<{if $menu_bottom }>
    <{include file="db:wfchannel_channellinks.tpl"}>
<{/if}>

<div class="copyright"><{$copyright}></div>
