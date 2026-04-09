<!--input:checkbox-->
{capture assign="sCapture"}
    {assign var=aSent value=$oPhormix->getDataSent()}
    <a id="{$element.attribute.name}"></a>
    <label for="{$element.attribute.id}{$data.label}" class="form-check-label">
        {$element.label}
        {if true === isset($element.attribute.required) && true === $element.attribute.required}<span class="text-danger">*</span>{/if}
    </label>
    <input
            type="hidden"
            {foreach $element.attribute as $attribute => $value}
                {if 'id' === $attribute || false === $value}
                    {continue}
                {else}
                    {$attribute}="{$value}"
                {/if}
            {/foreach}
            id="{$element.attribute.id}{$data.label}"
            class="form-check-input"
    >
    {if true === isset($element.description)}
        <div class="form-text">
            {$element.description}
        </div>
    {/if}
{/capture}
{$sCapture|tidyMarkup}
<!--/input:checkbox-->