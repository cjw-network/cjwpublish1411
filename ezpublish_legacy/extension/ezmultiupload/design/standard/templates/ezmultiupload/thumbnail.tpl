{if $result.errors|count()|gt(0)}
    <div class="error-block">
        <h2>{'Error'|i18n('extension/ezmultiupload')}</h2>
        <ul>
        {foreach $result.errors as $error}
            <li>{$error.description}</li>
        {/foreach}
        </ul>
    </div>
{elseif is_set( $result.contentobject )}
    {content_view_gui view='line_thumbnail' content_object=$result.contentobject}
{/if}

