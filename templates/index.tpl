<!--phormix.tpl--><!doctype html>{* @see https://getbootstrap.com/docs/5.3/getting-started/introduction/ *}
<html lang="en">
    <head>
        {include file="_head.tpl"}
    </head>
    <body>

        <!------------------------------------------------------------------------------------------------------------->
        {include file="menu.tpl"}
        <!------------------------------------------------------------------------------------------------------------->

        {* @see https://getbootstrap.com/docs/5.3/examples/cheatsheet/ *}
        <div class="container py-4 shadow bg-white padding20">
            <div class="text-center">
                {nocache}
                <h1 id="h1Title">
                    {$oDTRoutingAdditional->get_sTitle()}
                </h1>
                {/nocache}
                <p class="fs-4">
                    {* @see https://fontawesome.com/icons/php?f=brands&s=solid *}
                    a Formular Module for <img src="/favicon-32x32.png" style="border: none;margin-top: 5px;margin-right: 2px;"><b>Emvicy</b>, PHP <i class="fa-brands fa-php"></i> MVC Framework
                    <a class="btn btn-sm btn-outline-primary btn-lg" href="https://emvicy.com/" role="button" target="_blank">
                        <b>Emvicy</b> Documentation
                    </a>
                    <br>
                </p>
                <p>
                    <a class="btn btn-primary btn-lg" href="https://github.com/emvicy/Phormix" role="button" target="_blank">
                        Phormix at github
                    </a>
                </p>
            </div>

            <br>

            <!--content-->
                <!--Readme-->
                {if isset($sReadme)}{$sReadme}{/if}
                <!--/Readme-->
                <!--formular-->
                {if false === empty($oDTRoutingAdditional->get_sContent())}
                    {include file=$oDTRoutingAdditional->get_sContent()}
                {/if}
                <!--/formular-->
            <!--/content-->
        </div>

        <!------------------------------------------------------------------------------------------------------------->
        {include file="footer.tpl"}
        {include file="_noscript.tpl"}
        {include file="_cookieConsent.tpl"}
        <!------------------------------------------------------------------------------------------------------------->

        <!------------------------------------------------------------------------------------------------------------->
        {include file="_script.tpl"}
        <!------------------------------------------------------------------------------------------------------------->
    </body>
</html>