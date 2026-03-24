<!--input::hidden-->
{capture assign="sCapture"}
    {assign var=aSent value=$oPhormix->getDataSent()}
    <input
            {foreach $element.attribute as $attribute => $value}
                {if false === $value}
                    {continue}
                {else}
                    {$attribute}="{$value}"
                {/if}
            {/foreach}
    >
{/capture}
{$sCapture|tidyMarkup}
<!--/input::hidden-->