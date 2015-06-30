<ul>
    <{foreach item=new from=$block.new}>
    <li><a href="<{$xoops_url}>/modules/<{$block.dirname}>/index.php?cid=<{$new.id}>" title="<{$new.title_full}>"><{$new.title}></a>
        <{ if $new.date}>
        (<{$new.date}>)
        <{/if}>
    </li>
    <{/foreach}>
</ul>
