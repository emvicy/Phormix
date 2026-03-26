<style>
    {literal}
    fieldset {border: 1px dotted #CCC; padding: 20px;}
    input {font-family:  "Courier New", Courier, monospace;}
    input[required]{background-color: #fcfcfc;}
    input:invalid {
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAeVJREFUeNqkU01oE1EQ/mazSTdRmqSxLVSJVKU9RYoHD8WfHr16kh5EFA8eSy6hXrwUPBSKZ6E9V1CU4tGf0DZWDEQrGkhprRDbCvlpavan3ezu+LLSUnADLZnHwHvzmJlvvpkhZkY7IqFNaTuAfPhhP/8Uo87SGSaDsP27hgYM/lUpy6lHdqsAtM+BPfvqKp3ufYKwcgmWCug6oKmrrG3PoaqngWjdd/922hOBs5C/jJA6x7AiUt8VYVUAVQXXShfIqCYRMZO8/N1N+B8H1sOUwivpSUSVCJ2MAjtVwBAIdv+AQkHQqbOgc+fBvorjyQENDcch16/BtkQdAlC4E6jrYHGgGU18Io3gmhzJuwub6/fQJYNi/YBpCifhbDaAPXFvCBVxXbvfbNGFeN8DkjogWAd8DljV3KRutcEAeHMN/HXZ4p9bhncJHCyhNx52R0Kv/XNuQvYBnM+CP7xddXL5KaJw0TMAF8qjnMvegeK/SLHubhpKDKIrJDlvXoMX3y9xcSMZyBQ+tpyk5hzsa2Ns7LGdfWdbL6fZvHn92d7dgROH/730YBLtiZmEdGPkFnhX4kxmjVe2xgPfCtrRd6GHRtEh9zsL8xVe+pwSzj+OtwvletZZ/wLeKD71L+ZeHHWZ/gowABkp7AwwnEjFAAAAAElFTkSuQmCC);
        background-position: right; background-repeat: no-repeat; border: 1px dashed red;
    }
    input:required:valid {
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAepJREFUeNrEk79PFEEUx9/uDDd7v/AAQQnEQokmJCRGwc7/QeM/YGVxsZJQYI/EhCChICYmUJigNBSGzobQaI5SaYRw6imne0d2D/bYmZ3dGd+YQKEHYiyc5GUyb3Y+77vfeWNpreFfhvXfAWAAJtbKi7dff1rWK9vPHx3mThP2Iaipk5EzTg8Qmru38H7izmkFHAF4WH1R52654PR0Oamzj2dKxYt/Bbg1OPZuY3d9aU82VGem/5LtnJscLxWzfzRxaWNqWJP0XUadIbSzu5DuvUJpzq7sfYBKsP1GJeLB+PWpt8cCXm4+2+zLXx4guKiLXWA2Nc5ChOuacMEPv20FkT+dIawyenVi5VcAbcigWzXLeNiDRCdwId0LFm5IUMBIBgrp8wOEsFlfeCGm23/zoBZWn9a4C314A1nCoM1OAVccuGyCkPs/P+pIdVIOkG9pIh6YlyqCrwhRKD3GygK9PUBImIQQxRi4b2O+JcCLg8+e8NZiLVEygwCrWpYF0jQJziYU/ho2TUuCPTn8hHcQNuZy1/94sAMOzQHDeqaij7Cd8Dt8CatGhX3iWxgtFW/m29pnUjR7TSQcRCIAVW1FSr6KAVYdi+5Pj8yunviYHq7f72po3Y9dbi7CxzDO1+duzCXH9cEPAQYAhJELY/AqBtwAAAAASUVORK5CYII=);
        background-position: right; background-repeat: no-repeat; border: 1px solid green;
    }
    {/literal}
</style>
<!--
Bootstrap
@see https://getbootstrap.com/docs/5.3/forms/overview/
-->

<h1>Formular <code>"{$oPhormix->aConfig.form.name}"</code></h1>

<p>
    <a href="{$oDTRoute->get_path()}?config" target="_blank">show formular's final config</a>
</p>

<!--info-->
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th><code>&lt;form&gt;</form></code> attribute</th>
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
    <ul class="list-unstyled">
        {foreach key=sKey item=sItem from=$oPhormix->getErrorArray()}
            {if !is_array($sItem)}
                <li class="alert alert-danger">
                    <a href="#{$sKey}">{$sItem|escape}</a>
                </li>
            {/if}
        {/foreach}
    </ul>
    <!--/error-->
{/if}

{if false === empty($oPhormix->getMissingArray())}
    <!--missing-->
    <ul class="list-unstyled">
        {foreach key=sKey item=sItem from=$oPhormix->getMissingArray()}
            <li class="alert alert-warning">
                Missing: "{$sItem.label|escape}"
            </li>
        {/foreach}
    </ul>
    <!--/missing-->
{/if}

{if true === $oPhormix->bSuccess}
    <!--success-->
    <div class="alert alert-success">
        Thank you for submitting the Data.
    </div>

    <b>Data:</b>
    {MVC\Strings::ulli($oPhormix->getDataAccepted())}
    <!--/success-->
{/if}
<!--/messages-->

<br>

<!--form-->
{if false === $oPhormix->bSuccess}
    <form {$oPhormix->getMarkupFormAttributes()}>
        <fieldset>
            <legend>{$oPhormix->aConfig.form.name}</legend>

            {$oPhormix->getMarkupFormIdentifier()}
            {$oPhormix->getMarkupTicket()}

            {foreach item=element from=$oPhormix->aConfig.element}
                <div class="mb-3">
                    {if 'input' === $element.tag}
                        {if 'input_captcha' === $element.attribute['data-element']}
                            {include file="phormix/phormix_input_captcha.tpl"}
                        {elseif 'checkbox' === $element.attribute.type}
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
        </fieldset>
    </form>
{/if}
<!--/form-->