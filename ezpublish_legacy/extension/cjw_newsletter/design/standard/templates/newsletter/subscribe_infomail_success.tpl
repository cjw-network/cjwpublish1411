{* subsribe_info - template was nach versenden der subribe angezeigt wird
$email_input
$back_url_input
*}
<div class="newsletter newsletter-subscribe_infomail_success">

    <div class="border-box">
    <div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
    <div class="border-ml"><div class="border-mr"><div class="border-mc float-break">

    <h1>{'Newsletter'|i18n( 'cjw_newsletter/subscribe_infomail_success' )}</h1>

    <p class="newsletter-maintext">
        {'E-mail has been sent!'|i18n( 'cjw_newsletter/subscribe_infomail_success' )}
    </p>
    <p>
       {'If you are a valid newsletter user, an e-mail has been sent to you with all information required!'|i18n( 'cjw_newsletter/subscribe_infomail_success' )}
    </p>

    <p><a href="{$back_url_input}">{'back'|i18n( 'cjw_newsletter/subscribe_infomail_success' )}</a></p>


    </div></div></div>
    <div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
    </div>

</div>

