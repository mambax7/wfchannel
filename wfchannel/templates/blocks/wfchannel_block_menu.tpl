<table cellspacing="0">
    <tr>
        <td id="mainmenu">
            <!-- start module menu loop -->
            <{foreach item=menus from=$block.menu}>
            <a class="menuMain" href="<{$xoops_url}>/modules/<{$block.dirname}>/index.php?cid=<{$menus.id}>" title="<{$menus.title_full}>"><{$menus.title}></a>
            <{/foreach}>
        </td>
    </tr>
</table>
