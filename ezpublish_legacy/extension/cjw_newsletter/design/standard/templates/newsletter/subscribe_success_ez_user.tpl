{* subsribe_success_ez_user - if ez user has successfully subscribe to a newsletter

    $newsletter_user
    $mail_send_result
    $user_email_already_exists
    $subscription_result_array
    $back_url_input
*}
<div class="newsletter newsletter-subscribe_success_ez_user">

    <div class="border-box">
    <div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
    <div class="border-ml"><div class="border-mr"><div class="border-mc float-break">

    <h1>{'Newsletter - subscribe success'|i18n( 'cjw_newsletter/subscribe_success' )}</h1>

    <p  class="newsletter-maintext">
        {'You are registered for our newsletter.'|i18n( 'cjw_newsletter/subscribe_success' )}
    </p>

    <p><a href="{$back_url_input}">{'back'|i18n( 'cjw_newsletter/subscribe_success' )}</a></p>

    </div></div></div>
    <div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
    </div>

</div>

