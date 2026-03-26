{foreach key=sKey item=sItem from=$oDTRoutingAdditional->get_aScript()}
    <script src="{$sItem}" type="text/javascript"></script>
{/foreach}
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
