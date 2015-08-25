{literal}
<script type="text/javascript">
function toggleInputs( selection )
{
    var nameField = document.getElementById( "field1" );
    var localeField = document.getElementById( "field2" );

    if( selection.value == "-1" )
    {
        nameField.disabled = localeField.disabled = false;
    }
    else
    {
        nameField.disabled = localeField.disabled = true;
        nameField.value = localeField.value = "";
    }
}
</script>
{/literal}

<form name="languageform" action={concat( 'content/translations' )|ezurl} method="post" >

<div class="context-block content-translations content-translations-new">
{* DESIGN: Header START *}<div class="box-header"><div class="box-ml">
<h1 class="context-title">{'translation'|icon( 'normal', 'Translation'|i18n( 'design/admin/content/translationnew' ) )}&nbsp;{'New translation for content'|i18n( 'design/admin/content/translationnew' )}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

<div class="context-attributes">

{* Translation. *}
<div class="block">
<label for="localeSelector">{'Translation'|i18n( 'design/admin/content/translationnew' )}:</label>
<select id="localeSelector" name="LocaleID" onchange="toggleInputs(this); return false;">
  <option value="-1">{'Custom'|i18n( 'design/admin/content/translationnew' )}</option>
  {section var=Translations loop=fetch( content, locale_list, hash( with_variations, false() ) )}
      <option value="{$Translations.item.locale_full_code|wash}">
          {$Translations.item.intl_language_name|wash}{if $Translations.item.country_variation} [{$Translations.item.language_comment|wash}]{/if}
      </option>
  {/section}
</select>
</div>

{* Custom name. *}
<div class="block">
<label for="field1">{'Name of custom translation'|i18n( 'design/admin/content/translationnew' )}:</label>
<input id="field1" type="text" name="TranslationName" value=""  size="20" />
</div>

{* Custom locale. *}
<div class="block">
<label for="field2">{'Locale for custom translation'|i18n( 'design/admin/content/translationnew' )}:</label>
<input id="field2" type="text" name="TranslationLocale" value="" size="8" />
</div>

</div>

{* DESIGN: Content END *}</div></div></div>


{* Buttons. *}
<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml">
<div class="block">
{if $is_edit}
    <input class="button" type="submit" name="ChangeButton" value="{'OK'|i18n( 'design/admin/content/translationnew')}" />
{else}
    <input class="button" type="submit" name="StoreButton" value="{'OK'|i18n('design/admin/content/translationnew')}" />
{/if}

<input class="button" type="submit" name="CancelButton" value="{'Cancel'|i18n('design/admin/content/translationnew')}" />
</div>
{* DESIGN: Control bar END *}</div></div>
</div>

</div>

</form>

