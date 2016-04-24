<div class="page_links">|
    <{foreach item=chanlink from=$chanlink}>
        <a class="<{$chanlink.css}>" href="index.php<{$chanlink.id}>"><{$chanlink.title}></a>
        |
    <{/foreach}>
</div>
