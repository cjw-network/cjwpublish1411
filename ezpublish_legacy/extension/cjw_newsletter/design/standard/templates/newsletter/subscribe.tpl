{* DO NOT EDIT THIS FILE! Use an override template instead. *}

{*
    this template fetches all newsletter list for subscription
    => which list is displayed you can define in newsletter list configuration (datatype)

    newsletter/subscribe
*}
<div class="newsletter newsletter-subscribe">

    <div class="border-box">
    <div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
    <div class="border-ml"><div class="border-mr"><div class="border-mc float-break">

    {def $newsletter_root_node_id = ezini( 'NewsletterSettings', 'RootFolderNodeId', 'cjw_newsletter.ini' )
         $available_output_formats = 2

         $newsletter_system_node_list = fetch( 'content', 'tree', hash( 'parent_node_id', $newsletter_root_node_id,
                                                                        'class_filter_type', 'include',
                                                                        'class_filter_array', array( 'cjw_newsletter_system' ),
                                                                        'sort_by', array( 'name', true() ),
                                                                        'limitation', hash( )
                                                                      )
                                              )
         $newsletter_list_count = fetch( 'content', 'tree_count',
                                                            hash('parent_node_id', $newsletter_root_node_id,
                                                                 'extended_attribute_filter',
                                                                      hash( 'id', 'CjwNewsletterListFilter',
                                                                            'params', hash( 'siteaccess', array( 'current_siteaccess' ) ) ),
                                                                 'class_filter_type', 'include',
                                                                 'class_filter_array', array('cjw_newsletter_list'),
                                                                 'limitation', hash() )
                                                       )}

    <h1>{'Newsletter subscribe'|i18n( 'cjw_newsletter/subscribe' )}</h1>


    {* check if nl system is available *}
    {if or( $newsletter_system_node_list|count()|eq(0), $newsletter_list_count|eq(0) )}
        <div class="block">
            <p>
                {'No newsletters available.'|i18n( 'cjw_newsletter/subscribe' )}
            </p>
        </div>
    {else}

        <form name="subscribe" method="post" action={'/newsletter/subscribe/'|ezurl}>

            {* warnings *}
            {if and( is_set( $warning_array ), $warning_array|count|ne( 0 ) )}
            <div class="block">
                <div class="message-warning">
                    <h2>{'Input did not validate'|i18n('cjw_newsletter/subscribe')}</h2>
                    <ul>
                    {foreach $warning_array as $message_array_item}
                        <li><span class="key">{$message_array_item.field_key|wash}: </span><span class="text">{$message_array_item.message|wash()}</span></li>
                    {/foreach}
                    </ul>
                </div>
            </div>
            {/if}

            <div class="block header">
                <p>
                    {'Here you can subscribe to one of our newsletters.'|i18n( 'cjw_newsletter/subscribe' )}
                </p>
                <p>
                    {'Please fill in the boxes "first name" and "last name" and enter your e-mail address in the corresponding field. Then, select the newsletter you are interested in and the format you prefer.'|i18n( 'cjw_newsletter/subscribe' )}
                </p>
            </div>

            <div class="block">
                {foreach $newsletter_system_node_list as $system_node}

                    {def $newsletter_list_node_list = fetch( 'content', 'tree',
                                                                hash('parent_node_id', $system_node.node_id,
                                                                     'extended_attribute_filter',
                                                                          hash( 'id', 'CjwNewsletterListFilter',
                                                                                'params', hash( 'siteaccess', array( 'current_siteaccess' ) ) ),
                                                                     'class_filter_type', 'include',
                                                                     'class_filter_array', array('cjw_newsletter_list'),
                                                                     'limitation', hash() )
                                                           )
                         $newsletter_list_node_list_count = $newsletter_list_node_list|count
                    }

                    {if $newsletter_list_node_list_count|ne(0)}
                        <h2>{$system_node.data_map.title.content|wash}</h2>
                        <table border="0" width="100%">

                            {foreach $newsletter_list_node_list as $list_node sequence array( 'bglight', 'bgdark' ) as $style}
                                {def $list_id = $list_node.contentobject_id
                                     $list_selected_output_format_array = array(0)
                                     $td_counter = 0}

                                    {if is_set( $subscription_data_array.list_output_format_array[$list_id] )}
                                        {set $list_selected_output_format_array = $subscription_data_array.list_output_format_array[$list_id]}
                                    {/if}

                                <tr>
                                    {if $list_node.data_map.newsletter_list.content.output_format_array|count|ne(0)}

                                    {* check box subscribe to list *}
                                    <td valign="top" class="newsletter-list">
                                        <input type="hidden" name="Subscription_IdArray[]" value="{$list_id}" title="" />
                                        {if $newsletter_list_node_list_count|eq(1)}
                                            <input type="checkbox" name="Subscription_ListArray[]" value="{$list_id}" checked="checked" title="{$list_node.data_map.title.content|wash}" /> {$list_node.data_map.title.content|wash}
                                        {else}
                                            <input type="checkbox" name="Subscription_ListArray[]" value="{$list_id}"{if $subscription_data_array['list_array']|contains( $list_id )} checked="checked"{/if} title="{$list_node.data_map.title.content|wash}" /> {$list_node.data_map.title.content|wash}
                                        {/if}
                                    </td>
                                    {* outputformats *}

                                        {if $list_node.data_map.newsletter_list.content.output_format_array|count|gt(1)}

                                            {foreach $list_node.data_map.newsletter_list.content.output_format_array as $output_format_id => $output_format_name}
                                    <td class="newsletter-list"><div class="nl-outputformat"><input type="radio" name="Subscription_OutputFormatArray_{$list_id}[]" value="{$output_format_id}" {if $list_selected_output_format_array|contains( $output_format_id )} checked="checked"{/if} title="{$output_format_name|wash}" /> {$output_format_name|wash}&nbsp;{*({$output_format_id})*}</div></td>
                                            {set $td_counter = $td_counter|inc}
                                            {/foreach}

                                        {else}

                                            {foreach $list_node.data_map.newsletter_list.content.output_format_array as $output_format_id => $output_format_name}
                                    <td class="newsletter-list">&nbsp;<input type="hidden" name="Subscription_OutputFormatArray_{$list_id|wash}[]" value="{$output_format_id|wash}" title="{$output_format_name|wash}" /></td>
                                            {set $td_counter = $td_counter|inc}
                                            {/foreach}

                                        {/if}

                                    {else}
                                    {* do nothing *}
                                    {/if}

                                    {* create missing  <td> *}
                                    {while $td_counter|lt( $available_output_formats )}
                                    <td>&nbsp;{*$td_counter} < {$available_output_formats*}</td>
                                    {set $td_counter = $td_counter|inc}
                                    {/while}

                                </tr>
                                {undef $list_id $list_selected_output_format_array $td_counter $newsletter_list_node_list_count}
                            {/foreach}
                        </table>
                    {/if}

                    {undef $newsletter_list_node_list}
                {/foreach}
            </div>

            {* salutation *}
            <div class="block" id="nl-salutation">
                <label>{"Salutation"|i18n( 'cjw_newsletter/subscribe' )}:</label>
                {foreach $available_salutation_array as $salutation_id => $salutation_name}
                    <input type="radio" name="Subscription_Salutation" value="{$salutation_id|wash}"{if and( is_set( $subscription_data_array['salutation'] ), $subscription_data_array['salutation']|eq( $salutation_id ) )} checked="checked"{/if} title="{$salutation_name|wash}" /> {$salutation_name|wash}&nbsp;
                {/foreach}
            </div>

            {* First name. *}
            <div class="block">
                <label for="Subscription_FirstName">{"First name"|i18n( 'cjw_newsletter/subscribe' )}:</label>
                <input class="halfbox" id="Subscription_FirstName" type="text" name="Subscription_FirstName" value="{cond( and( is_set( $user), $subscription_data_array['first_name']|eq('') ), $user.contentobject.data_map.first_name.content|wash , $subscription_data_array['first_name'] )|wash}" title="{'First name of the subscriber.'|i18n( 'cjw_newsletter/subscribe' )}"
                       {*cond( is_set( $user ), 'disabled="disabled"', '')*} />
            </div>

            {* Last name. *}
            <div class="block">
                <label for="Subscription_LastName">{"Last name"|i18n( 'cjw_newsletter/subscribe' )}:</label>
                <input class="halfbox" id="Subscription_LastName" type="text" name="Subscription_LastName" value="{cond( and( is_set( $user ), $subscription_data_array['last_name']|eq('') ), $user.contentobject.data_map.last_name.content|wash , $subscription_data_array['last_name'] )|wash}" title="{'Last name of the subscriber.'|i18n( 'cjw_newsletter/subscribe' )}"
                       {*cond( is_set( $user ), 'disabled="disabled"', '')*} />
            </div>

            {* Email. *}
            <div class="block">
                <label for="Subscription_Email">{"E-mail"|i18n( 'cjw_newsletter/subscribe' )}*:</label>
                <input class="halfbox" id="Subscription_Email" type="text" name="Subscription_Email" value="{cond( and( is_set( $user ), $subscription_data_array['email']|eq('') ), $user.email|wash(), $subscription_data_array['email']|wash )}" title="{'Email of the subscriber.'|i18n( 'cjw_newsletter/subscribe' )}" />
            </div>

            <div class="block">
                <input type="hidden" name="BackUrlInput" value="{cond( ezhttp_hasvariable('BackUrlInput'), ezhttp('BackUrlInput'), 'newsletter/subscribe'|ezurl('no'))}" />
                <input class="button" type="submit" name="SubscribeButton" value="{'Subscribe'|i18n( 'cjw_newsletter/subscribe' )}" title="{'Add to subscription.'|i18n( 'cjw_newsletter/subscribe' )}" />
                <a href={$node_url|ezurl}><input class="button" type="submit" name="CancelButton" value="{'Cancel'|i18n( 'cjw_newsletter/subscribe' )}" /></a>
            </div>


            <div class="block footer">
                <h3>{'Data Protection'|i18n( 'cjw_newsletter/subscribe' )}:</h3>
                <p>{'Your e-mail address will under no circumstances be passed on to unauthorized third parties.'|i18n( 'cjw_newsletter/subscribe' )}</p>

                <h3>{'Further Options'|i18n( 'cjw_newsletter/subscribe' )}:</h3>

                <p>
                {def $link = concat('<a href=', '/newsletter/subscribe_infomail'|ezurl() ,'>' ) }

                {"You want to %unsubscribelink or %changesubscribelink your profile?"|i18n('cjw_newsletter/subscribe',, hash( '%unsubscribelink' , concat( $link ,'unsubscribe'|i18n('cjw_newsletter/subscribe'), '</a>'),
                                                                                                                            '%changesubscribelink' , concat( $link,'change'|i18n('cjw_newsletter/subscribe'), '</a>')
                                                                                                                            ))}
                {undef $link}
                </p>

                <p>{'* mandatory fields'|i18n( 'cjw_newsletter/subscribe' )}</p>
            </div>
        </form>
    {/if}

    </div></div></div>
    <div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
    </div>

</div>
