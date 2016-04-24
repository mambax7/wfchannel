<{if $linktous.linkpagelogo }>
    <div align="center"><img src='<{$xoops_url}>/<{$linktous.path}>/<{$linktous.linkpagelogo}>' name='image' id='image' alt=''/></div>
<{/if}>

<h3 align="left"><{$lang_linktous}></h3>
<{if $menu_top }>
    <div style="padding-top: 12px; text-align: center;" nowrap:>|
        <{foreach item=chanlink2 from=$chanlink}>
            <a <{$chanlink2.css}> href="index.php<{$chanlink2.id}>"><{$chanlink2.title}></a>
            |
        <{/foreach}>
    </div>
    <br clear='all'>
<{/if}>

<{$extfileform}>

<{if $menu_bottom }>
    <div style="padding-top: 12px; text-align: center;" nowrap:>|
        <{foreach item=chanlink from=$chanlink}>
            <a <{$chanlink.css}> href="index.php<{$chanlink.id}>"><{$chanlink.title}></a>
            |
        <{/foreach}>
    </div>
    <br clear='all'>
<{/if}>
