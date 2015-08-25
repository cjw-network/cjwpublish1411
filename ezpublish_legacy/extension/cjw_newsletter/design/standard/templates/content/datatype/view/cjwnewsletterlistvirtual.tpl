{*?template charset=utf-8?*}
{* DO NOT EDIT THIS FILE! Use an override template instead.
    content/datatype/view/cjwnewsletterlistvirtual.tpl
    *}

{def $newsletter_list_content = $attribute.content}

{*$attribute|attribute(show,1)*}

    <div class="block float-break">
        {* siteaccess_array *}
     {*   <div class="element">
            <label>{'Show in siteaccess'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}</label>
            {$newsletter_list_content.siteaccess_array|implode( ', ')}
        </div>*}
    </div>

    {def $main_siteaccess_info = $newsletter_list_content.available_siteaccess_list[$newsletter_list_content.main_siteaccess]}
    <div class="block float-break">
    {* main_siteaccess *}
        <div class="element">
            <label>{'Main siteaccess'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}</label>
            {$newsletter_list_content.main_siteaccess|wash}
        </div>
        <div class="element">
            <label>{'Main siteaccess site url'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}</label>
            {$main_siteaccess_info.site_url|wash}
        </div>
        <div class="element">
            <label>{'Main siteaccess locale'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}</label>
            {$main_siteaccess_info.locale|wash}
        </div>
    </div>

    <div class="block float-break">
        {* output_format_array *}
        <div class="element">
            <label>{'Newsletter output formats'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}:</label>
                {$newsletter_list_content.output_format_array|implode( ', ')}
        </div>
    </div>

     {* Auto approve registered users. *}
    {*<div class="block float-break">

        <div class="element">
            <label>{'Automatically approve subscription after user registration?'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}:</label>
            {$newsletter_list_content.auto_approve_registered_user|choose( 'No'|i18n( 'cjw_newsletter/datatype/cjwnewsletterlist' ), 'Yes'|i18n( 'cjw_newsletter/datatype/cjwnewsletterlist' ) )}
        </div>
    </div>*}




    <div class="block float-break">

        {* email data *}
        <div class="element">
            <label>{'Email sender'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}:</label> {$newsletter_list_content.email_sender|wash}
        </div>
        <div class="element">
            <label>{'Email sender name'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}:</label> {$newsletter_list_content.email_sender_name|wash}
        </div>
        <div class="element">
            <label>{'Email reply-to'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}:</label> {$newsletter_list_content.email_reply_to|wash}
        </div>

        <div class="element">
            <label>{'Email return-path'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}:</label> {$newsletter_list_content.email_return_path|wash}
        </div>
        <div class="element">
            <label>{'Email receiver test'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}:</label> {$newsletter_list_content.email_receiver_test|wash}
        </div>
    </div>

    <div class="block float-break">
        <div class="element">
            <label>{'Personalize content'|i18n('cjw_newsletter/datatype/cjwnewsletterlist')}:</label>
            {$newsletter_list_content.personalize_content|choose( 'No'|i18n( 'cjw_newsletter/datatype/cjwnewsletterlist' ), 'Yes'|i18n( 'cjw_newsletter/datatype/cjwnewsletterlist' ) )}
        </div>
    </div>

    <div class="break"></div>

{undef $newsletter_list_content}
