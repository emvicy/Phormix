<!--input:radio-->
{capture assign="sCapture"}
    {assign var=aSent value=$oPhormix->getDataSent()}
    {$element.label} {if true === isset($element.attribute.required) && true === $element.attribute.required}<span class="text-danger">*</span>{/if}
    {foreach $element.filter.validate.expect.value as $data}
        <div class="form-check form-check-inline">
            <input
                    {foreach $element.attribute as $attribute => $value}
                        {if 'id' === $attribute || 'value' === $attribute || false === $value}
                            {continue}
                        {else}
                            {$attribute}="{$value}"
                        {/if}
                    {/foreach}
                    id="{$element.attribute.id}{$data.value}"
                    value="{$data.value}"
                    class="form-check-input"
                    {if $aSent[$element.attribute.name] === $data.value}checked{/if}
            >
            <a id="{$element.attribute.name}"></a>
            <label for="{$element.attribute.id}{$data.label}" class="form-check-label">
                {$data.label}
            </label>
        </div>
    {/foreach}
{/capture}
{$sCapture|tidyMarkup}
<!--/input:radio-->