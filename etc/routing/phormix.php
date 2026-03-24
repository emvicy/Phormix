<?php

/*
 * modify this Datatype `DTRoutingAdditional` to your needs in:
 *      `modules/Phormix/etc/config/Phormix/config/_dataType.php`
 * create the Datatype class finally on cli:
 *      `php emvicy datatype`
 */


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

/*
 * Routes
 */
\MVC\Route::MIX(['GET', 'POST'],
    sPath: '/phormix/',
    sClassMethod: '\Phormix\Controller\Index::index',
    mOptional: clone $oDTRoutingAdditional->set_sTitle('Phormix'),
    sTag: 'phormix',
);

$oDTRoutingAdditional->set_sContent('phormix/phormix_formular.tpl');

\MVC\Route::MIX(['GET', 'POST'],
    sPath: '/phormix/profile',
    sClassMethod: '\Phormix\Controller\Index::profile',
    mOptional: clone $oDTRoutingAdditional->set_sTitle('Formular "Profile"'),
    sTag: 'phormix_profile',
);

\MVC\Route::MIX(['GET', 'POST'],
    sPath: '/phormix/chain',
    sClassMethod: '\Phormix\Controller\Index::chain',
    mOptional: clone $oDTRoutingAdditional->set_sTitle('Formular "Chain"'),
    sTag: 'phormix_chain',
);