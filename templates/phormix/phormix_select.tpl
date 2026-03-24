<!--select-->
{capture assign="sCapture"}
    {assign var=aSent value=$oPhormix->getDataSent()}
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
    <option disabled value> -- please select an option -- </option>
    {foreach $element.filter.validate.expect.value as $key => $data}
        <option value="{$data.value}">{$data.label}</option>
    {/foreach}
    </select>
{/capture}
{$sCapture|tidyMarkup}
<!--/select-->