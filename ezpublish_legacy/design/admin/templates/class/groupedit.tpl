<form name="GroupEdit" method="post" action={concat( $module.functions.groupedit.uri, '/', $classgroup.id )|ezurl}>

<div class="context-block">

{* DESIGN: Header START *}<div class="box-header">

<h1 class="context-title">{$classgroup.name|wash|classgroup_icon( normal, $classgroup.name|wash )}&nbsp;{'Edit <%group_name> [Class group]'|i18n( 'design/admin/class/groupedit',, hash( '%group_name', $classgroup.name ) )|wash}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div>

{* DESIGN: Content START *}<div class="box-content">
<div class="context-attributes">

{* Name. *}
<div class="block">
    <label for="classGroupName">{'Name'|i18n( 'design/admin/class/groupedit' )}:</label>
    <input class="halfbox" id="classGroupName" name="Group_name" value="{$classgroup.name|wash}" />
</div>
</div>

{* DESIGN: Content END *}</div>

<div class="block">
<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc">
<div class="block">
<input class="defaultbutton" type="submit" name="StoreButton" value="{'OK'|i18n( 'design/admin/class/groupedit' )}" />
<input class="button" type="submit" name="DiscardButton" value="{'Cancel'|i18n( 'design/admin/class/groupedit' )}" />
</div>
{* DESIGN: Control bar END *}</div>
</div>
</div>

</div>

</form>




{literal}
<script type="text/javascript">
jQuery(function( $ )//called on document.ready
{
    document.getElementById('classGroupName').select();
    document.getElementById('classGroupName').focus();
});
</script>
{/literal}
