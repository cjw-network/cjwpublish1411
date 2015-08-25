{set-block scope=root variable=cache_ttl}0{/set-block}
<div class="newsletter">

{include uri='design:infocollection_validation.tpl'}

<div class="content-navigation">

{* Content window. *}
<div class="context-block">

{* DESIGN: Header START *}<div class="box-header">

{def $js_class_languages = $node.object.content_class.prioritized_languages_js_array
     $disable_another_language = cond( eq( 0, count( $node.object.content_class.can_create_languages ) ),"'edit-class-another-language'", '-1' )
     $disabled_sub_menu = "['class-createnodefeed', 'class-removenodefeed']"
     $hide_status = ''}

{if $node.is_invisible}
    {set $hide_status = concat( '(', $node.hidden_status_string, ')' )}
{/if}

{* Check if user has rights and if there are any RSS/ATOM Feed exports for current node *}
{if is_set( ezini( 'RSSSettings', 'DefaultFeedItemClasses', 'site.ini' )[ $node.class_identifier ] )}
    {def $create_rss_access = fetch( 'user', 'has_access_to', hash( 'module', 'rss', 'function', 'edit' ) )}
    {if $create_rss_access}
        {if fetch( 'rss', 'has_export_by_node', hash( 'node_id', $node.node_id ) )}
            {set $disabled_sub_menu = "'class-createnodefeed'"}
        {else}
            {set $disabled_sub_menu = "'class-removenodefeed'"}
        {/if}
    {/if}
{/if}

<h1 class="context-title"><a href={concat( '/class/view/', $node.object.contentclass_id )|ezurl} onclick="ezpopmenu_showTopLevel( event, 'ClassMenu', ez_createAArray( new Array( '%classID%', {$node.object.contentclass_id}, '%objectID%', {$node.contentobject_id}, '%nodeID%', {$node.node_id}, '%currentURL%', '{$node.url|wash( javascript )}', '%languages%', {$js_class_languages} ) ), '{$node.class_name|wash(javascript)}', {$disabled_sub_menu}, {$disable_another_language} ); return false;">{$node.class_identifier|class_icon( normal, $node.class_name )}</a>&nbsp;{$node.name|wash}&nbsp;[{$node.class_name|wash}]&nbsp;{$hide_status}</h1>

{undef $js_class_languages $disable_another_language $disabled_sub_menu $hide_status}

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div>


{* DESIGN: Content START *}<div class="box-content">

<div class="context-information">
<p class="left modified">{'Last modified'|i18n( 'design/admin/node/view/full' )}: {$node.object.modified|l10n(shortdatetime)}, <a href={$node.object.current.creator.main_node.url_alias|ezurl}>{$node.object.current.creator.name|wash}</a> ({'Node ID'|i18n( 'design/admin/node/view/full' )}: {$node.node_id}, {'Object ID'|i18n( 'design/admin/node/view/full' )}: {$node.object.id})</p>
<p class="right translation">{$node.object.current_language_object.locale_object.intl_language_name}&nbsp;<img src="{$node.object.current_language|flag_icon}" alt="{$language_code}" style="vertical-align: middle;" /></p>
<div class="break"></div>
</div>


{* Newsletter list statistic *}
{include uri = 'design:cjw_newsletter_list_statistic.tpl'
         name = 'Statistic'
         list_node = $node
         icons = true()}


<div class="tab-block">

{include uri='design:window_controls.tpl'}

</div>

{* DESIGN: Content END *}</div>

<div class="controlbar">
{* DESIGN: Control bar START *}

<form method="post" action={'content/action'|ezurl}>
<input type="hidden" name="TopLevelNode" value="{$node.object.main_node_id}" />
<input type="hidden" name="ContentNodeID" value="{$node.node_id}" />
<input type="hidden" name="ContentObjectID" value="{$node.contentobject_id}" />

<div class="button-left">
<div class='block'>
{* Edit button. *}
{def $can_create_languages = $node.object.can_create_languages
     $languages            = fetch( 'content', 'prioritized_languages' )}
{if $node.can_edit}
    {*if and(eq( $languages|count, 1 ), is_set( $languages[0] ) )}
            <input name="ContentObjectLanguageCode" value="{$languages[0].locale}" type="hidden" />
    {else}
            <select name="ContentObjectLanguageCode">
            {foreach $node.object.can_edit_languages as $language}
                       <option value="{$language.locale}"{if $language.locale|eq($node.object.current_language)} selected="selected"{/if}>{$language.name|wash}</option>
            {/foreach}
            {if gt( $can_create_languages|count, 0 )}
                <option value="">{'New translation'|i18n( 'design/admin/node/view/full')}</option>
            {/if}
            </select>
    {/if*}
    <input name="ContentObjectLanguageCode" value="{$node.object.current_language}" type="hidden" />
    <input class="button" type="submit" name="EditButton" value="{'Edit'|i18n( 'design/admin/node/view/full' )}" title="{'Edit the contents of this item.'|i18n( 'design/admin/node/view/full' )}" />
{else}
    {*<select name="ContentObjectLanguageCode" disabled="disabled">
        <option value="">{'Not available'|i18n( 'design/admin/node/view/full')}</option>
    </select>*}
    <input class="button-disabled" type="submit" name="EditButton" value="{'Edit'|i18n( 'design/admin/node/view/full' )}" title="{'You do not have permission to edit this item.'|i18n( 'design/admin/node/view/full' )}" disabled="disabled" />
{/if}
{undef $can_create_languages}

{* Move button. *}

{if $node.can_move}
    <input class="button" type="submit" name="MoveNodeButton" value="{'Move'|i18n( 'design/admin/node/view/full' )}" title="{'Move this item to another location.'|i18n( 'design/admin/node/view/full' )}" />
{else}
    <input class="button-disabled" type="submit" name="MoveNodeButton" value="{'Move'|i18n( 'design/admin/node/view/full' )}" title="{'You do not have permission to move this item to another location.'|i18n( 'design/admin/node/view/full' )}" disabled="disabled" />
{/if}

{* Remove button. *}
{if $node.can_remove}
    <input class="button" type="submit" name="ActionRemove" value="{'Remove'|i18n( 'design/admin/node/view/full' )}" title="{'Remove this item.'|i18n( 'design/admin/node/view/full' )}" />
{else}
    <input class="button-disabled" type="submit" name="ActionRemove" value="{'Remove'|i18n( 'design/admin/node/view/full' )}" title="{'You do not have permission to remove this item.'|i18n( 'design/admin/node/view/full' )}" disabled="disabled" />
{/if}

</div>
</div>

<div class="button-right">
        <p class='versions'>
    {* Link to manage versions *}
    <a href={concat("content/history/", $node.contentobject_id )|ezurl} title="{'View and manage (copy, delete, etc.) the versions of this object.'|i18n( 'design/admin/content/edit' )}">{'Manage versions'|i18n( 'design/admin/content/edit' )}</a>
    </p>
</div>

<div class="button-right">
<div class="block">
    {* Custom content action buttons. *}
    {section var=ContentActions loop=$node.object.content_action_list}
        <input class="button" type="submit" name="{$ContentActions.item.action}" value="{$ContentActions.item.name}" />
    {/section}
</div>
</div>

<div class="float-break"></div>

<div class="button-left">
<div class='block'>

{if $node.can_create}
<form action={'content/action'|ezurl()} name="CreateNewNewsletterEdition" method="post">
    <input type="hidden" value="{ezini( 'RegionalSettings', 'ContentObjectLocale' )}" name="ContentLanguageCode"/>
    <input type="hidden" value="{$node.node_id}" name="ContentNodeID"/>
    <input type="hidden" value="{$node.node_id}" name="NodeID"/>
    <input type="hidden" value="cjw_newsletter_edition" name="ClassIdentifier"/>
    <input class="defaultbutton" type="submit" name="NewButton" value="{'Create newsletter here'|i18n( 'cjw_newsletter/cjw_newsletter_list' )}" />
</form>
{else}
<input class="button-disabled" type="button" name="NewButton" value="{'Create newsletter here'|i18n( 'cjw_newsletter/cjw_newsletter_list' )}" />
{/if}


<form name="CreateNewNewsletterUser" method="post" style="display:inline;" action={'newsletter/user_create'|ezurl}>
    <input type="hidden" name="Subscription_IdArray[]" value="{$node.contentobject_id}" />
    <input type="hidden" name="Subscription_ListArray[]" value="{$node.contentobject_id}" />
    <input type="hidden" name="RedirectUrlActionCancel" value="{$node.url_alias}" />
    <input type="hidden" name="RedirectUrlActionStore" value="{$node.url_alias}" />
    <input class="button" type="submit" name="NewSubscriptionButton" value="{'Create new Subscription'|i18n( 'cjw_newsletter/subscription_list' )}" />
</form>



</div>

</div>

<div class="button-right">
<div class="block">
{* virtual list create button *}

{if $node.can_create}
<br />
<form action={'content/action'|ezurl()} name="CreateNewNewsletterListVirtual" method="post">
    <input type="hidden" value="{ezini( 'RegionalSettings', 'ContentObjectLocale' )}" name="ContentLanguageCode"/>
    <input type="hidden" value="{$node.node_id}" name="ContentNodeID"/>
    <input type="hidden" value="{$node.node_id}" name="NodeID"/>
    <input type="hidden" value="cjw_newsletter_list_virtual" name="ClassIdentifier"/>
    <input class="button" type="submit" name="NewButton" value="{'Create filter here'|i18n( 'cjw_newsletter/cjw_newsletter_list' )}" />
</form>
{else}
<input class="button-disabled" type="button" name="NewButton" value="{'Create filter here'|i18n( 'cjw_newsletter/cjw_newsletter_list' )}" />
{/if}
</div>
</div>

<div class="float-break"></div>
</form>
{* DESIGN: Control bar END *}
</div>


</div>


{* Children window.*}
{if $node.is_container}
    {include uri='design:cjw_newsletter_list_children.tpl'}
{else}
    {include uri='design:no_children.tpl'}
{/if}

</div>
</div>
