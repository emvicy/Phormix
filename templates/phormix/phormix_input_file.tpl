<!--input:default-->
{capture assign="sCapture"}
    {assign var=aSent value=$oPhormix->getDataSent()}
    <a id="{$element.attribute.name}"></a>
    <label for="{$element.attribute.id}" class="form-check-label">
        {$element.label}
        {if true === isset($element.attribute.required) && true === $element.attribute.required} <span class="text-danger">*</span>{/if}
    </label>
    <input type="hidden" name="{$element.attribute.name}" value="{$element.attribute.name}">
    <input
            {foreach $element.attribute as $attribute => $value}
                {if false === $value || 'value' === $attribute}
                    {continue}
                {elseif 'name' === $attribute}
                    {$attribute}="{$value}[]"
                {else}
                    {$attribute}="{$value}"
                {/if}
            {/foreach}
            class="form-control"
            {if true === isset($aSent[$element.attribute.name])}value="{$aSent[$element.attribute.name]}"{/if}
    >
    {if true === isset($element.description)}
    <div class="form-text">
        {$element.description}
    </div>
    {/if}
{/capture}
{$sCapture|tidyMarkup}
<!--/input:default-->