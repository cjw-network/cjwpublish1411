<li id="node-tab-commentsbundle" class="{if $last}last{else}middle{/if}{if $node_tab_index|eq('commentsbundle')} selected{/if}">
    {if $tabs_disabled}
        <span class="disabled" title="{'Tab is disabled, enable with toggler to the left of these tabs.'|i18n( 'design/admin/node/view/full' )}">{'Comments'|i18n( 'ezcommentsbundle/design/tabs/header' )}</span>
    {else}
        <a href={concat( $node_url_alias, '/(tab)/commentsbundle' )|ezurl} title="{'Content comments overview.'|i18n( 'ezcommentsbundle/design/tabs/header' )}">{'Comments'|i18n( 'ezcommentsbundle/design/tabs/header' )}</a>
    {/if}
</li>
