<!--input:default-->
{capture assign="sCapture"}

    <!--get data sent by post-->
    {assign var=aSent value=$oPhormix->getDataSent()}
    <!--get data from session-->
    {if true === empty($aSent) && true === isset($smarty.session.Phormix.ChainStep) && true === isset($smarty.session.Phormix.Chain[$smarty.session.Phormix.ChainStep].aData)}
        {assign var=aSent value=$smarty.session.Phormix.Chain[$smarty.session.Phormix.ChainStep].aData}
    {/if}

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