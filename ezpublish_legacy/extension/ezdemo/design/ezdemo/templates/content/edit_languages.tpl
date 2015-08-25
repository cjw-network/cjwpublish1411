{def $languages=fetch('content', 'prioritized_languages')
     $object_language_codes=$object.language_codes
     $can_edit=true()}

<form action={concat('content/edit/',$object.id)|ezurl} method="post">

{if $show_existing_languages}
    {* Translation a user is able to edit *}
    {set-block variable=$existing_languages_output}
    {foreach $languages as $language}
        {if $object_language_codes|contains($language.locale)}
            {if fetch('content', 'access', hash( 'access', 'edit',
                                                 'contentobject', $object,
                                                 'language', $language.locale ) )}
                <label>
                    <input name="EditLanguage" type="radio" value="{$language.locale|wash}"{run-once} checked="checked"{/run-once} /> {$language.name|wash}
                </label>
                <div class="labelbreak"></div>
            {/if}
        {/if}
    {/foreach}
    {/set-block}

    {if $existing_languages_output|trim}
        <fieldset>
        <legend>{'Existing languages'|i18n('design/ezdemo/content/edit_languages')}</legend>
        <p>{'Select the language you want to use when editing the object.'|i18n('design/ezdemo/content/edit_languages')}:</p>

        {$existing_languages_output}
        </fieldset>
    {/if}
{/if}

{* Translation a user is able to create *}
{set-block variable=$nonexisting_languages_output}
{foreach $languages as $language}
    {if $object_language_codes|contains($language.locale)|not}
        {if fetch('content', 'access', hash( 'access', 'edit',
                                             'contentobject', $object,
                                             'language', $language.locale ) )}
            <label>
               <input name="EditLanguage" type="radio" value="{$language.locale|wash}"{run-once} checked="checked"{/run-once} /> {$language.name|wash}
            </label>
            <div class="labelbreak"></div>
        {/if}
    {/if}
{/foreach}
{/set-block}

{if $nonexisting_languages_output|trim}
    <fieldset>
    <legend>{'New languages'|i18n('design/ezdemo/content/edit_languages')}</legend>
    <p>{'Select the language you want to add to the object.'|i18n('design/ezdemo/content/edit_languages')}:</p>

    {$nonexisting_languages_output}

    <p>{'Select the language the new translation will be based on.'|i18n('design/ezdemo/content/edit_languages')}:</p>

    <label>
        <input name="FromLanguage" type="radio" checked="checked" value="" /> {'Use an empty, untranslated draft'|i18n('design/ezdemo/content/edit_languages')}
    </label>
    <div class="labelbreak"></div>

    {foreach $object.languages as $language}
        <label>
            <input name="FromLanguage" type="radio" value="{$language.locale|wash}" /> {$language.name|wash}
        </label>
        <div class="labelbreak"></div>
    {/foreach}
    </fieldset>
{else}
    {if $show_existing_languages|not}
        {set $can_edit=false()}
        <p>{'You do not have permission to create a translation in another language.'|i18n('design/ezdemo/content/edit_languages')}</p>

        {* Translation a user is able to edit *}
        {set-block variable=$existing_languages_output}
        {foreach $languages as $language}
            {if $object_language_codes|contains($language.locale)}
                {if fetch('content', 'access', hash( 'access', 'edit',
                                                     'contentobject', $object,
                                                     'language', $language.locale ) )}
                    <label>
                        <input name="EditLanguage" type="radio" value="{$language.locale|wash}"{run-once} checked="checked"{/run-once} /> {$language.name|wash}
                    </label>
                    <div class="labelbreak"></div>
                {/if}
            {/if}
        {/foreach}
        {/set-block}

        {if $existing_languages_output|trim}
            <fieldset>
            {set $can_edit=true()}
            <legend>{'Existing languages'|i18n('design/ezdemo/content/edit_languages')}</legend>
            <p>{'However, you can select one of the following languages for editing.'|i18n('design/ezdemo/content/edit_languages')}:</p>
        
            {$existing_languages_output}
            </fieldset>
        {/if}
    {elseif $existing_languages_output|trim|not}
        {set $can_edit=false()}
        {'You do not have permission to edit the object in any available languages.'|i18n('design/ezdemo/content/edit_languages')}
    {/if}
{/if}

<div class="block">
    {if $can_edit}
        <input class="button" type="submit" name="LanguageSelection" value="{'Edit'|i18n('design/ezdemo/content/edit_languages')}" />
    {/if}
    <input class="button" type="submit" name="CancelDraftButton" value="{'Cancel'|i18n('design/ezdemo/content/edit_languages')}" />
</div>

</form>
