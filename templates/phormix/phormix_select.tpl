<!--select-->
{capture assign="sCapture"}

    <!--get data sent by post-->
    {assign var=aSent value=$oPhormix->getDataSent()}
    <!--get data from session-->
    {if true === empty($aSent) && true === isset($smarty.session.Phormix.ChainStep) && true === isset($smarty.session.Phormix.Chain[$smarty.session.Phormix.ChainStep].aData)}
        {assign var=aSent value=$smarty.session.Phormix.Chain[$smarty.session.Phormix.ChainStep].aData}
    {/if}

    <a id="{$element.attribute.name}"></a>
    <label for="id_{$element.attribute.id}" class="form-check-label">
        {$element.label}
        {if true === isset($element.attribute.required) && true === $element.attribute.required}{$oPhormix->getDTPhormixSetup()->get_sMandatoryCode()}{/if}
    </label>
    <select
            {foreach $element.attribute as $attribute => $value}
                {if false === $value}
                    {continue}
                {elseif 'id' === $attribute}
                    {$attribute}="id_{$value}"
                {elseif 'name' === $attribute}
                    {$attribute}="{$value}[]"
                {else}
                    {$attribute}="{$value}"
                {/if}
            {/foreach}
            class="form-select"
    >
    {foreach $element.filter.validate.expect.value as $key => $data}
        <option value="{$data.value}" {if true === isset($aSent[$element.attribute.name]) && current($aSent[$element.attribute.name]) === $data.value}selected{/if}>{$data.label}</option>
    {/foreach}
    </select>
    {if true === isset($element.description)}
        <div class="form-text">
            {$element.description}
        </div>
    {/if}
{/capture}
{$sCapture|tidyMarkup}
<!--/select-->