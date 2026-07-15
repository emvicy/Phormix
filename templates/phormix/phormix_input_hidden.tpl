<!--input::hidden-->
{capture assign="sCapture"}

    <!--get data sent by post-->
    {assign var=aSent value=$oPhormix->getDataSent()}
    <!--get data from session-->
    {if true === empty($aSent) && true === isset($smarty.session.Phormix.ChainStep) && true === isset($smarty.session.Phormix.Chain[$smarty.session.Phormix.ChainStep].aData)}
        {assign var=aSent value=$smarty.session.Phormix.Chain[$smarty.session.Phormix.ChainStep].aData}
    {/if}

    <input
            {foreach $element.attribute as $attribute => $value}
                {if false === $value}
                    {continue}
                {elseif 'id' === $attribute}
                    {$attribute}="id_{$value}"
                {elseif true === $value}
                    {$attribute}
                {else}
                    {$attribute}="{$value}"
                {/if}
            {/foreach}
    >
{/capture}
{$sCapture|tidyMarkup}
<!--/input::hidden-->