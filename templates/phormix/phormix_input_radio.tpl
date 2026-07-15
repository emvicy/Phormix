<!--input:radio-->
{capture assign="sCapture"}

    <!--get data sent by post-->
    {assign var=aSent value=$oPhormix->getDataSent()}
    <!--get data from session-->
    {if true === empty($aSent) && true === isset($smarty.session.Phormix.ChainStep) && true === isset($smarty.session.Phormix.Chain[$smarty.session.Phormix.ChainStep].aData)}
        {assign var=aSent value=$smarty.session.Phormix.Chain[$smarty.session.Phormix.ChainStep].aData}
    {/if}

    {$element.label} {if true === isset($element.attribute.required) && true === $element.attribute.required}{$oPhormix->getDTPhormixSetup()->get_sMandatoryCode()}{/if}
    {foreach $element.filter.validate.expect.value as $data}
        <div class="form-check form-check-inline">
            <input
                    {foreach $element.attribute as $attribute => $value}
                        {if 'id' === $attribute || 'value' === $attribute || false === $value}
                            {continue}
                        {elseif true === $value}
                            {$attribute}
                        {else}
                            {$attribute}="{$value}"
                        {/if}
                    {/foreach}
                    id="id_{$element.attribute.id}{$data.value}"
                    value="{$data.value}"
                    class="form-check-input"
                    {if true === isset($aSent[$element.attribute.name]) && $aSent[$element.attribute.name] === $data.value}checked{/if}
            >
            <a id="{$element.attribute.name}"></a>
            <label for="id_{$element.attribute.id}{$data.value}" class="form-check-label">
                {$data.label}
                {if true === isset($data.description)}
                    <div class="form-text">{$data.description}</div>
                {/if}
            </label>
        </div>
    {/foreach}
    {if true === isset($element.description)}<br><span class="form-text">{$element.description}</span>{/if}
{/capture}
{$sCapture|tidyMarkup}
<!--/input:radio-->