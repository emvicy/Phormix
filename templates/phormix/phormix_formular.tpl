
<!--
Bootstrap
@see https://getbootstrap.com/docs/5.3/forms/overview/
-->

<h1>Formular <code>"{$oPhormix->aConfig.form.name}"</code></h1>

<p>
    <a href="{$oDTRoute->get_path()}?config" target="_blank">show formular's config</a>
</p>

<!--info-->
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>attribute</th>
            <th>value</th>
        </tr>
    </thead>
    <tbody>
    {foreach $oPhormix->aConfig.form as $attribute => $value}
        <tr>
            <td>{$attribute}</td>
            <td><kbd>{$value}</kbd></td>
        </tr>
    {/foreach}
    </tbody>
</table>
<!--/info-->

<!--breadcrumb-->
{if isset($aBreadcrumb)}
    <nav style="--bs-breadcrumb-divider: '➤';background-color: #ECECEC;border: 1px solid #DEE2E6;" aria-label="breadcrumb">
        <ol class="breadcrumb padding20">
        {foreach $aBreadcrumb as $iIndex => $aData}
            <li class="breadcrumb-item">
                <a href="#" class="btn btn-sm btn-outline-primary">Step {$iIndex+1}: {$aData.label}</a>
            </li>
        {/foreach}
        </ol>
    </nav>
{/if}
<!--/breadcrumb-->

<br>

<!--messages-->
{if false === empty($oPhormix->getErrorArray())}
    <!--error-->
    <ul class="feedback-message error-message">
        {foreach key=sKey item=sItem from=$oPhormix->getErrorArray()}
            {if !is_array($sItem)}<li>{$sItem|escape}</li>{/if}
        {/foreach}
    </ul>
    <!--/error-->
{/if}

{if false === empty($oPhormix->getMissingArray())}
    <!--missing-->
    <ul class="feedback-message error-message">
        {foreach key=sKey item=sItem from=$oPhormix->getMissingArray()}
            <li>
                Missing: "{$sItem.label|escape}"
            </li>
        {/foreach}
    </ul>
    <!--/missing-->
{/if}


{*{if !empty($aMessage)}*}
{*    <ul class="feedback-message">*}
{*        {foreach key=sKey item=sItem from=$aMessage}*}
{*            <li>*}
{*                <b>{$aConfig.index[$sKey].label|escape}</b>:*}
{*                <ul>*}
{*                    {foreach key=key2 item=item2 from=$sItem}*}
{*                        {foreach key=key3 item=item3 from=$item2}*}
{*                            <li>{$key2}:{$key3}: {$item3}</li>*}
{*                        {/foreach}*}
{*                    {/foreach}*}
{*                </ul>*}
{*            </li>*}
{*        {/foreach}*}
{*    </ul>*}
{*    <br>*}
{*{/if}*}

{if true === $oPhormix->bSuccess}
    <ul>
        <li>Thank you for your message.</li>
    </ul>
{/if}
<!--/messages-->

<br>

<!--form-->
{if false === $oPhormix->bSuccess}
    <form {$oPhormix->getMarkupFormAttributes()}>
        {$oPhormix->getMarkupFormIdentifier()}
        {$oPhormix->getMarkupTicket()}
        {foreach item=element from=$oPhormix->aConfig.element}
            <div class="mb-3">
                {if 'input' === $element.tag}
                    {if 'checkbox' === $element.attribute.type}
                        {include file="phormix/phormix_input_checkbox.tpl"}
                    {elseif 'radio' === $element.attribute.type}
                        {include file="phormix/phormix_input_radio.tpl"}
                    {elseif 'hidden' === $element.attribute.type}
                        {include file="phormix/phormix_input_hidden.tpl"}
                    {else}
                        {include file="phormix/phormix_input_default.tpl"}
                    {/if}
                {elseif 'select' === $element.tag}
                    {include file="phormix/phormix_select.tpl"}
                {elseif 'textarea' === $element.tag}
                    {include file="phormix/phormix_textarea.tpl"}
                {/if}
            </div>
        {/foreach}
        <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
    </form>
{/if}
<!--/form-->