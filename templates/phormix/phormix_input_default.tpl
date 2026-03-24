<!--input:default-->
{capture assign="sCapture"}
    {assign var=aSent value=$oPhormix->getDataSent()}
    <label for="{$element.attribute.id}" class="form-check-label">
        {$element.label}
        {if true === isset($element.attribute.required) && true === $element.attribute.required} <span class="text-danger">*</span>{/if}
    </label>
    <input
            {foreach $element.attribute as $attribute => $value}
                {if false === $value || 'value' === $attribute}
                    {continue}
                {else}
                    {$attribute}="{$value}"
                {/if}
            {/foreach}
            class="form-control"
            {if true === isset($aSent[$element.attribute.name])}value="{$aSent[$element.attribute.name]}"{/if}
    >
{/capture}
{$sCapture|tidyMarkup}
<!--/input:default-->