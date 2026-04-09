<!--select-->
{capture assign="sCapture"}
    {assign var=aSent value=$oPhormix->getDataSent()}
    <a id="{$element.attribute.name}"></a>
    <label for="{$element.attribute.id}" class="form-check-label">
        {$element.label}
        {if true === isset($element.attribute.required) && true === $element.attribute.required}<span class="text-danger">*</span>{/if}
    </label>
    <select
            {foreach $element.attribute as $attribute => $value}
                {if false === $value}
                    {continue}
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