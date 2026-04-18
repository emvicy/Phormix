<?php

/**
 * @name $PhormixController
 */
namespace Phormix\Controller;

use MVC\Config;
use MVC\DataType\DTRequestIn;
use MVC\DataType\DTRoute;
use MVC\Session;
use Phormix\DataType\DTPhormixChain;
use Phormix\DataType\DTPhormixSetup;
use Phormix\Model\PhormixChain;


class Chain extends _Master
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
        $oDTPhormixChain = DTPhormixChain::create()
            ->add_aDTPhormixSetup(DTPhormixSetup::create()
                ->set_sLabel('Name / Company')
                ->set_sConfigYamlFile(Config::get_MVC_MODULES_DIR() . '/Phormix/chain1.yaml')
                ->set_sElementDirectory(Config::get_MVC_MODULES_DIR() . '/Phormix/element/')
                ->set_sValidateClass('\Phormix\Model\PhormixValidate'))
            ->add_aDTPhormixSetup(DTPhormixSetup::create()
                ->set_sLabel('Address')
                ->set_sConfigYamlFile(Config::get_MVC_MODULES_DIR() . '/Phormix/chain2.yaml')
                ->set_sElementDirectory(Config::get_MVC_MODULES_DIR() . '/Phormix/element/')
                ->set_sValidateClass('\Phormix\Model\PhormixValidate'))
            ->add_aDTPhormixSetup(DTPhormixSetup::create()
                ->set_sLabel('Submit data')
                ->set_sConfigYamlFile(Config::get_MVC_MODULES_DIR() . '/Phormix/chain3.yaml')
                ->set_sElementDirectory(Config::get_MVC_MODULES_DIR() . '/Phormix/element/')
                ->set_sValidateClass('\Phormix\Model\PhormixValidate'));

        $oPhormixChain = new PhormixChain($oDTRequestIn, $oDTPhormixChain);
        $oPhormix = $oPhormixChain->getPhormix();
        $oPhormix = $oPhormixChain->setActionOnRoutePath($oDTRoute, $oPhormix);
        $oPhormix = $oPhormixChain->proceed($oPhormix);

        MODIFY: {

            // set autofocus to Salutation
            (isset($oPhormix->aConfig['element']['Salutation']['attribute']['autofocus']))
                ? $oPhormix->aConfig['element']['Salutation']['attribute']['autofocus'] = true
                : false;

            // modify description text of "PrivacyPolicy"
            (isset( $oPhormix->aConfig['element']['PrivacyPolicy']['description']))
                ? $oPhormix->aConfig['element']['PrivacyPolicy']['description'].= '<br>Privacy policy <a href="https://www.example.com/" target="_blank">https://www.example.com/</a>'
                : false;
        }

        // show config
        $this->showConfigOnDemand($oPhormix);

        // create new captcha text; take identifier from config
        $sCaptchaId = ($oPhormix->aConfig['element']['Captcha']['attribute']['id'] ?? 'Captcha');
        Session::is('Phormix')->set($sCaptchaId, \Phimcap::text());

        if (true === $oPhormix->bSuccess)
        {
            // get Data Array
            $aData = $oPhormixChain->getDataAccepted();

            // get uploaded Files
            $aFiles = $oPhormixChain->getFilesAccepted();

            // reset
            $oPhormixChain->reset($oPhormix);
        }

        view()->assign('oDTPhormixChain', $oDTPhormixChain);
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