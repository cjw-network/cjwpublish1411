<div class="span{$outer_column_size} extra-menu">
    {if is_array( $pagedata.extra_menu )}
        {foreach $pagedata.extra_menu as $extra_menu}
        {include uri=concat('design:parts/', $extra_menu, '.tpl')}
            {delimiter}<div class="hr"></div>{/delimiter}
        {/foreach}
        {else}
    {include uri=concat('design:parts/', $pagedata.extra_menu, '.tpl')}
    {/if}
</div>
