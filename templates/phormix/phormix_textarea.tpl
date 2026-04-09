<!--textarea-->
{capture assign="sCapture"}
    {assign var=aSent value=$oPhormix->getDataSent()}
    <a id="{$element.attribute.name}"></a>
    <label for="{$element.attribute.id}" class="form-check-label">
        {$element.label}
        {if true === isset($element.attribute.required) && true === $element.attribute.required}<span class="text-danger">*</span>{/if}
    </label>
    <textarea
            {foreach $element.attribute as $attribute => $value}
                {if false === $value}
                    {continue}
                {else}
                    {$attribute}="{$value}"
                {/if}
            {/foreach}
            class="form-control"
    >{if true === isset($aSent[$element.attribute.name])}{$aSent[$element.attribute.name]}{/if}</textarea>
    {if true === isset($element.description)}
        <div class="form-text">
            {$element.description}
        </div>
    {/if}
{/capture}
{$sCapture|tidyMarkup}
<!--/textarea-->