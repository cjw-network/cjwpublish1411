{ezcss_require( array( 'jqmodal.css', 'contentstructure-tree.css' ) )}
{ezscript_require( array( 'jquery-migrate-1.1.1.min.js', 'jqmodal.js', 'eztagsselectparent.js' ) )}

<div class="context-block tags-add">
    <div class="box-header">
        <h1 class="context-title">{"New synonym tag"|i18n( 'extension/eztags/tags/edit' )} ({"Main tag ID"|i18n( 'extension/eztags/tags/edit' )}: {$main_tag.id}, {"Main tag name"|i18n( 'extension/eztags/tags/edit' )}: {$main_tag.keyword|wash})</h1>
        <div class="header-mainline"></div>
    </div>

    {if $error|count}
        <div class="message-error">
            <h2>{$error|wash}</h2>
        </div>
    {/if}

    <div class="box-content">
        <form name="tageditform" id="tageditform" enctype="multipart/form-data" method="post" action={concat( 'tags/addsynonym/', $main_tag.id )|ezurl}>
            <div class="block tag-edit-keyword">
                <label>{'Synonym name'|i18n( 'extension/eztags/tags/edit' )}</label>
                <input id="keyword" class="halfbox" type="text" size="70" name="TagEditKeyword" value="{cond( ezhttp_hasvariable( 'TagEditKeyword', 'post' ), ezhttp( 'TagEditKeyword', 'post' ), '' )|trim|wash}" />
            </div>

            <div class="controlbar">
                <div class="block">
                    <input class="defaultbutton" type="submit" name="SaveButton" value="{'Save'|i18n( 'extension/eztags/tags/edit' )}" />
                    <input class="button" type="submit" name="DiscardButton" value="{'Discard'|i18n( 'extension/eztags/tags/edit' )}" onclick="return confirmDiscard( '{'Are you sure you want to discard changes?'|i18n( 'extension/eztags/tags/edit' )|wash( javascript )}' );" />
                    <input type="hidden" name="DiscardConfirm" value="1" />
                </div>
            </div>
        </form>
    </div>
</div>

{literal}
<script language="JavaScript" type="text/javascript">
function confirmDiscard( question )
{
    // Disable/bypass the reload-based (plain HTML) confirmation interface.
    document.tageditform.DiscardConfirm.value = "0";

    // Ask user if she really wants do it, return this to the handler.
    return confirm( question );
}
</script>
{/literal}
