<div class="shop-orderview">
    <h1>{"Order %order_id [%order_status]"|i18n("design/base/shop",,
         hash( '%order_id', $order.order_nr,
               '%order_status', $order.status_name|wash ) )}</h1>

    {shop_account_view_gui view=html order=$order}
    {def $currency = fetch( 'shop', 'currency', hash( 'code', $order.productcollection.currency_code ) )
         $locale = false()
         $symbol = false()}

    {if $currency}
        {set locale = $currency.locale
             symbol = $currency.symbol}
    {/if}

    <div class="content-basket">
    <table cellspacing="0">
    <tr>
	    <th>
        {"Quantity"|i18n("design/base/shop")}
        </th>
        <th>
        {"VAT"|i18n("design/base/shop")}
        </th>
        <th>
    	{"Price"|i18n("design/base/shop")}
        </th>
        <th>
	    {"Discount"|i18n("design/base/shop")}
        </th>
        <th>
     	{"Total price"|i18n("design/base/shop")}
        </th>
    </tr>
    {section var=product_item loop=$order.product_items sequence=array(bglight,bgdark)}
    <tr>
        <td class="{$product_item.sequence} product-name" colspan="6">
        <a href={concat("/content/view/full/",$product_item.node_id,"/")|ezurl}>{$product_item.object_name|wash}</a>
        </td>
    </tr>
    <tr>
        <td class="{$product_item.sequence} product-details">
            {$product_item.item_count}
    	</td>
	    <td class="{$product_item.sequence} product-details">
        {$product_item.vat_value} %
    	</td>
        <td class="{$product_item.sequence} product-details">
        {$product_item.price_inc_vat|l10n( 'currency', $locale, $symbol )}
    	</td>
	    <td class="{$product_item.sequence} product-details">
        {$product_item.discount_percent}%
        </td>
	    <td class="{$product_item.sequence} product-details product-price">
        {$product_item.total_price_inc_vat|l10n( 'currency', $locale, $symbol )}
	    </td>
     </tr>
     {section show=$product_item.item.item_object.option_list}
     <tr>
         <td class="{$product_item.sequence}" colspan='4'>
         {"Selected options"|i18n("design/base/shop")}

         <table class="shop-option_list">
         {section var=option_item loop=$product_item.item_object.option_list}
         <tr>
             <td class="shop-option_name">{$option_item.name|wash}<br/>
             <td class="shop-option_value">{$option_item.value|wash}</td>
             <td class="shop-option_price">{if $option_item.price|ne( 0 )}{$option_item.price|l10n( 'currency', $locale, $symbol )}{/if}</td>
         </tr>
         {/section}
         </table>
         </td>
     </tr>
     {/section}
     {/section}
     <tr>
         <td class="product-subtotal" colspan="4">
         <strong>{"Subtotal inc. VAT"|i18n("design/base/shop")}:</strong>
         </td>
         <td class="product-subtotal">
         <strong>{$order.product_total_inc_vat|l10n( 'currency', $locale, $symbol )}</strong>
         </td>
     </tr>
     {foreach $order.order_info.additional_info as $order_item_type => $additional_info}
     <tr>
         <td class="product-subtotal" colspan="4">
         {if $order_item_type|eq('ezcustomshipping')}
         {"Shipping total inc. VAT"|i18n("design/base/shop")}:
         {else}
         {"Item total inc. VAT"|i18n("design/base/shop")}:
         {/if}
         </td>
         <td class="product-subtotal">
         {$additional_info.total.total_price_inc_vat|l10n( 'currency', $locale, $symbol )}
         </td>
     </tr>
     {/foreach}
     <tr>
         <td class="product-subtotal" colspan="4">
         <strong>{"Total inc. VAT"|i18n("design/base/shop")}:</strong>
         </td>
         <td class="product-subtotal">
         <strong>{$order.total_inc_vat|l10n( 'currency', $locale, $symbol )}</strong>
         </td>
     </tr>
     </table>
     </div>



    <h2>{"Order summary"|i18n("design/base/shop")}:</h2>
<table class="list" cellspacing="0" cellpadding="0" border="0">
<tr>
    <td class="bgdark product-subtotal">
    {"Subtotal of items ex. VAT"|i18n("design/base/shop")}:
    </td>
    <td class="bgdark product-subtotal">
    {$order.product_total_ex_vat|l10n( 'currency', $locale, $symbol )}
    </td>
</tr>
{foreach $order.order_info.additional_info as $order_item_type => $additional_info}
<tr>
    <td class="bgdark product-subtotal">
    {if $order_item_type|eq('ezcustomshipping')}
    {"Shipping total ex. VAT"|i18n("design/base/shop")}:
    {else}
    {"Item total ex. VAT"|i18n("design/base/shop")}:
    {/if}
    </td>
    <td class="bgdark product-subtotal">
    {$additional_info.total.total_price_ex_vat|l10n( 'currency', $locale, $symbol )}
    </td>
</tr>
{/foreach}
{if $order.order_info.additional_info|count|gt(0)}
{foreach $order.order_info.price_info.items as $vat_value => $order_info
           sequence array(bglight, bgdark) as $sequence}
{if $order_info.total_price_vat|gt(0)}
<tr>
	<td class="{$sequence} product-subtotal">
{"Total VAT"|i18n("design/base/shop")} ({$vat_value}%)
	</td>
	<td class="{$sequence} product-subtotal">
	{$order_info.total_price_vat|l10n( 'currency', $locale, $symbol )}
	</td>
</tr>
{/if}
{/foreach}
{/if}
<tr>
    <td class="bgdark product-subtotal">
    <b>{"Order total"|i18n("design/base/shop")}:</b>
    </td>
    <td class="bgdark product-subtotal">
    <b>{$order.total_inc_vat|l10n( 'currency', $locale, $symbol )}</b>
    </td>
</tr>
</table>

    <h2>{"Order history"|i18n("design/base/shop")}:</h2>
    <table class="list" cellspacing="0" cellpadding="0" border="0">
    {let order_status_history=fetch( shop, order_status_history,
                                     hash( 'order_id', $order.order_nr ) )}
    {section var=history loop=$order_status_history sequence=array(bglight,bgdark)}
    <tr>
        <td class="{$history.sequence} date">{$sel_pre}{$history.modified|l10n( shortdatetime )}</td>
    	<td class="{$history.sequence}">{$history.status_name|wash}</td>
    </tr>
    {/section}
    {/let}

    </table>
</div>