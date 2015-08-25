{ezscript_require( 'tools/ezjsselection.js' )}
<table class="list" cellspacing="0">
<tr>
    <th class="tight">
    {section show=eq( $select_type, 'checkbox' )}
        <img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection'|i18n( 'design/ezdemo/content/browse_mode_list' )}" title="{'Invert selection'|i18n( 'design/ezdemo/content/browse_mode_list' )}" onclick="ezjs_toggleCheckboxes( document.browse, '{$select_name}[]' ); return false;" />
    {section-else}
        &nbsp;
    {/section}
    </th>
    <th class="wide">
    {'Name'|i18n( 'design/ezdemo/content/browse_mode_list' )}
    </th>
    <th class="tight">
    {'Type'|i18n( 'design/ezdemo/content/browse_mode_list' )}
    </th>
</tr>

{section var=Nodes loop=$node_array sequence=array( bglight, bgdark )}
  <tr class="{$Nodes.sequence}">
    <td>
    {* Note: The tpl code for $ignore_nodes_merge with the eq, unique and count
             is just a replacement for a missing template operator.
             If there are common elements the unique array will have less elements
             than the merged one
             In the future this should be replaced with a  new template operator that checks
             one array against another and returns true if elements in the first
             exists in the other *}
     {let ignore_nodes_merge=merge( $browse.ignore_nodes_select_subtree, $Nodes.item.path_array )}
     {section show=and( or( $browse.permission|not,
                           cond( is_set( $browse.permission.contentclass_id ),
                                 fetch( content, access, hash( access,          $browse.permission.access,
                                                               contentobject,   $Nodes.item,
                                                               contentclass_id, $browse.permission.contentclass_id ) ),
                                 fetch( content, access, hash( access,          $browse.permission.access,
                                                               contentobject,   $Nodes.item ) ) ) ),
                           $browse.ignore_nodes_select|contains( $Nodes.item.node_id )|not,
                           eq( $ignore_nodes_merge|count,
                               $ignore_nodes_merge|unique|count ) )}
        {section show=is_array( $browse.class_array )}
            {section show=$browse.class_array|contains( $Nodes.item.object.content_class.identifier )}
                <input type="{$select_type}" name="{$select_name}[]" value="{$Nodes.item[$select_attribute]}" />
            {section-else}
                <input type="{$select_type}" name="" value="" disabled="disabled" />
            {/section}
        {section-else}
            {section show=and( or( eq( $browse.action_name, 'MoveNode' ), eq( $browse.action_name, 'CopyNode' ), eq( $browse.action_name, 'AddNodeAssignment' ) ), $Nodes.item.object.content_class.is_container|not )}
                <input type="{$select_type}" name="{$select_name}[]" value="{$Nodes.item[$select_attribute]}" disabled="disabled" />
            {section-else}
                <input type="{$select_type}" name="{$select_name}[]" value="{$Nodes.item[$select_attribute]}" />
            {/section}
        {/section}
    {section-else}
        <input type="{$select_type}" name="" value="" disabled="disabled" />
    {/section}
    {/let}
    </td>
    <td>

    {* Replaces node_view_gui... *}
    {* Note: The tpl code for $ignore_nodes_merge with the eq, unique and count
             is just a replacement for a missing template operator.
             If there are common elements the unique array will have less elements
             than the merged one
             In the future this should be replaced with a  new template operator that checks
             one array against another and returns true if elements in the first
             exists in the other *}
    {let ignore_nodes_merge=merge( $browse.ignore_nodes_click, $Nodes.item.path_array )}
    {section show=eq( $ignore_nodes_merge|count,
                      $ignore_nodes_merge|unique|count )}
        {section show=and( or( ne( $browse.action_name, 'MoveNode' ), ne( $browse.action_name, 'CopyNode' ) ), $Nodes.item.object.content_class.is_container )}
            <a href={concat( '/content/browse/', $Nodes.item.node_id )|ezurl}>{$Nodes.item.name|wash}</a>
        {section-else}
            {$Nodes.item.name|wash}
        {/section}
    {section-else}
        {$Nodes.item.name|wash}
    {/section}
    {/let}

    </td>
    <td class="class">
    {$Nodes.item.object.content_class.name|wash}
    </td>
 </tr>
{/section}
</table>
