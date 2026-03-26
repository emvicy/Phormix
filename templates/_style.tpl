{foreach key=sKey item=sItem from=$oDTRoutingAdditional->get_aStyle()}<link href="{$sItem}" rel="stylesheet" type="text/css">
{/foreach}
<style>
    {literal}
    body {padding-top: 7rem;/* Move down content because of fixed navbar */}
    pre {
        background-color: whitesmoke;
        border: 1px solid #e0e0e0;
        padding: 20px 10px;
    }
    {/literal}
</style>
