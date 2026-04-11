<?php

/**
 * @name $PhormixController
 */
namespace Phormix\Controller;

use MVC\Config;
use MVC\DataType\DTRequestIn;
use MVC\DataType\DTRoute;
use MVC\Session;
use Phormix\DataType\DTPhormixSetup;
use Phormix\Model\Phormix;


class Profile extends _Master
{
    /**
     * @return void
     * @throws \ReflectionException
     */
    public static function __preconstruct()
    {
        parent::__preconstruct();
    }

    /**
     * @param \MVC\DataType\DTRequestIn $oDTRequestIn
     * @param \MVC\DataType\DTRoute     $oDTRoute
     * @throws \ReflectionException
     */
    public function __construct(DTRequestIn $oDTRequestIn, DTRoute $oDTRoute)
    {
        parent::__construct($oDTRequestIn, $oDTRoute);
    }

    /**
     * @param \MVC\DataType\DTRequestIn $oDTRequestIn
     * @param \MVC\DataType\DTRoute     $oDTRoute
     * @return void
     * @throws \ReflectionException
     */
    public function formular(DTRequestIn $oDTRequestIn, DTRoute $oDTRoute)
    {
        $oPhormix = Phormix::init(
            DTPhormixSetup::create()
                ->set_sLabel('This is my formular')
                ->set_sConfigYamlFile(Config::get_MVC_MODULES_DIR() . '/Phormix/profile.yaml')
                ->set_sElementDirectory(Config::get_MVC_MODULES_DIR() . '/Phormix/element/')
                ->set_sValidateClass('\Phormix\Model\PhormixValidate')
        );

        // modify description text of "PrivacyPolicy"
        $oPhormix->aConfig['element']['PrivacyPolicy']['description'].= '<br>Privacy policy <a href="https://www.example.com/" target="_blank">https://www.example.com/</a>';

        // run Phormix
        $oPhormix->run();

        // show config
        $this->showConfigOnDemand($oPhormix);

        // Form was successfully sent; Validation succeeded
        if (true === $oPhormix->bSuccess)
        {
            // get Data Array
            $aData = $oPhormix->getDataAccepted();

            // get uploaded Files
            $aFiles = $oPhormix->getFilesAccepted();

            // reset
            $oPhormix->reset(bForce: true);
        }

        // create new captcha text; take identifier from config
        $sCaptchaId = ($oPhormix->aConfig['element']['Captcha']['attribute']['id'] ?? 'Captcha');
        Session::is('Phormix')->set($sCaptchaId, \Phimcap::text());

        view()->assign('oPhormix', $oPhormix);
        view()->assign('oDTRoute', $oDTRoute);
        view()->assign('aData', ($aData ?? array()));
        view()->assign('aFiles', ($aFiles ?? array()));
        view()->autoAssign();
    }

    /**
     * @throws \ReflectionException
     * @throws \SmartyException
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}