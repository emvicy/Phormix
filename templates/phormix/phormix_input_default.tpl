<!--input:default-->
{capture assign="sCapture"}
    <!--get data sent by post-->
    {assign var=aSent value=$oPhormix->getDataSent()}
{*    <!--get prior data from session-->*}
{*    {if true === empty($aSent)}*}
{*        {assign var=aSent value=$smarty.session.Chain[$smarty.session.Chain.step].aData}*}
{*    {/if}*}

    <a id="{$element.attribute.name}"></a>
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
    {if true === isset($element.explain)}
        <div class="form-text">
            {$element.explain}
        </div>
    {/if}
{/capture}
{$sCapture|tidyMarkup}
<!--/input:default-->