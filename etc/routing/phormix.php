<?php

// template
$oDTRoutingAdditional = \MVC\DataType\DTRoutingAdditional::create()
    ->set_sTitle('Phormix')
    ->set_sTemplate('index.tpl')
    ->set_sContent('')
    ->set_aStyle(array (
        '/Emvicy/assets/bootstrap-5.3.3-dist/css/bootstrap.min.css',
        '/Emvicy/assets/fontawesome-free-6.7.2-web/css/all.min.css',
        '/Emvicy/styles/Emvicy.min.css',
    ))
    ->set_aScript(array (
        '/Emvicy/assets/jquery-3.7.1/jquery-3.7.1.min.js',
        '/Emvicy/assets/jquery-cookie-1.4.1/jquery.cookie.min.js',
        '/Emvicy/assets/popper-v2.11.8/popper.min.js',
        '/Emvicy/assets/bootstrap-5.3.3-dist/js/bootstrap.min.js',
        '/Emvicy/scripts/Emvicy.min.js',
    ));

// captcha image
\MVC\Route::GET('/captcha/{sCaptchaId}/','\Phormix\Controller\Index::captcha');

// start
\MVC\Route::MIX(['GET', 'POST'],
    sPath: '/phormix/',
    sClassMethod: '\Phormix\Controller\Index::readme',
    mOptional: clone $oDTRoutingAdditional->set_sTitle('Phormix'),
    sTag: 'phormix_readme',
);

// formular "Profile"
\MVC\Route::MIX(['GET', 'POST'],
    sPath: '/phormix/profile',
    sClassMethod: '\Phormix\Controller\Profile::formular',
    mOptional: clone $oDTRoutingAdditional->set_sTitle('single-page form "Profile"')->set_sContent('phormix/phormix_formular.tpl'),
    sTag: 'phormix_profile',
);

// formular "Chain"
\MVC\Route::MIX(['GET', 'POST'],
    sPath: '/phormix/chain',
    sClassMethod: '\Phormix\Controller\Chain::formular',
    mOptional: clone $oDTRoutingAdditional->set_sTitle('multi-page form "Chain1|2|3"')->set_sContent('phormix/phormix_formular_chain.tpl'),
    sTag: 'phormix_chain',
);