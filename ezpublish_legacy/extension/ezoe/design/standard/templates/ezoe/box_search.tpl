{default box_embed_mode         = true()
         box_class_filter_array = array()
         box_classes            = fetch( 'class', 'list', hash( 'sort_by', array( 'name', true() ) ) )
         box_has_access         = fetch( 'user', 'has_access_to', hash( 'module', 'ezoe',
                                                                    'function', 'search' ) )}
    <div class="panel" id="search_box" style="display: none; position: relative;">
    {if $box_embed_mode}
        <a id="embed_search_go_back_link" title="Go back" href="JavaScript:void(0);" style="position: absolute; top: 0px; right: -5px;"><img width="16" height="16" border="0" src={"tango/emblem-unreadable.png"|ezimage} /></a>
    {/if}
    {if $box_has_access}
        <div id="search_progress" class="progress-indicator" style="display: none;"></div>
        <table class="properties">
        <tr>
            <td>
                <input type="hidden" name="SearchLimit" value="10" />
                <input type="hidden" name="EncodingLoadImages" value="1" />
                <input type="hidden" name="EncodingFetchChildrenCount" value="1" />
                <input id="SearchText" name="SearchStr" type="text" value="" onkeypress="return eZOEPopupUtils.searchEnter(event)" title="{'Enter the word you want to search for here, for instance the name of the content you are looking for.'|i18n('design/standard/ezoe/wai')}" />    
                <select name="SearchContentClassID[]" multiple="multiple" size="4" style="vertical-align:middle" title="{'Lets you limit the content type your searching for, by limiting the eZ Publish content classes that are returned in the search result.'|i18n('design/standard/ezoe/wai')}">
                <option value=""{if $:box_class_filter_array|not} selected="selected"{/if}>{"All"|i18n("design/standard/ezoe")}</option>
                {foreach $box_classes as $class}
                    <option value="{$class.id|wash}"{if $:box_class_filter_array|contains( $class.identifier )} selected="selected"{/if}>{$class.name|wash}</option>
                {/foreach}
                </select>
            </td>
            <td><input type="submit" name="SearchButton" id="SearchButton" value="{'Search'|i18n('design/admin/content/search')}" onclick="return eZOEPopupUtils.searchEnter(event, true)" /></td>
        </tr>
        <tr>
            <td colspan="2">
            <table class="node_datalist" id="search_box_prev">
            <thead>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
            </td>
        </tr>
        </table>
    {else}
        <p>{"Your current user does not have the proper privileges to access this page."|i18n('design/standard/error/kernel')}</p>
    {/if}
    </div>
{/default}