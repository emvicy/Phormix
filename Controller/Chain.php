<?php

/**
 * @name $PhormixController
 */
namespace Phormix\Controller;

use MVC\Config;
use MVC\DataType\DTFileUpload;
use MVC\DataType\DTRequestIn;
use MVC\DataType\DTRoute;
use MVC\Session;
use Phormix\DataType\DTPhormixChain;
use Phormix\DataType\DTPhormixSetup;
use Phormix\Model\Phormix;
use Phormix\Model\PhormixChain;


class Chain extends _Master
{
    /**
     * @var array|array[]
     */
    protected $aChain = array();

    /**
     * @var \Phormix\Model\Phormix|null
     */
    protected $oPhormix;

    /**
     * @var DTPhormixChain
     */
    protected $oDTPhormixChain;

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

//        // declare chained forms
//        $this->oDTPhormixChain = DTPhormixChain::create()
//            ->add_aDTPhormixSetup(DTPhormixSetup::create()
//                ->set_sLabel('Name / Company')
//                ->set_sConfigYamlFile(Config::get_MVC_MODULES_DIR() . '/Phormix/chain1.yaml')
//                ->set_sElementDirectory(Config::get_MVC_MODULES_DIR() . '/Phormix/element/')
//                ->set_sValidateClass('\Phormix\Model\PhormixValidate'))
//            ->add_aDTPhormixSetup(DTPhormixSetup::create()
//                ->set_sLabel('Address')
//                ->set_sConfigYamlFile(Config::get_MVC_MODULES_DIR() . '/Phormix/chain2.yaml')
//                ->set_sElementDirectory(Config::get_MVC_MODULES_DIR() . '/Phormix/element/')
//                ->set_sValidateClass('\Phormix\Model\PhormixValidate'))
//            ->add_aDTPhormixSetup(DTPhormixSetup::create()
//                ->set_sLabel('Submit data')
//                ->set_sConfigYamlFile(Config::get_MVC_MODULES_DIR() . '/Phormix/chain3.yaml')
//                ->set_sElementDirectory(Config::get_MVC_MODULES_DIR() . '/Phormix/element/')
//                ->set_sValidateClass('\Phormix\Model\PhormixValidate'))
//        ;
//        view()->assign('oDTPhormixChain', $this->oDTPhormixChain);
//
//        (false === isset($_SESSION['Chain']['step']))
//            ? $_SESSION['Chain']['step'] = 0
//            : false
//        ;
//
//        // jump between forms by query param "step"
//        (false === empty($oDTRequestIn->get_queryArray()['step'] ?? ''))
//            ? $_SESSION['Chain']['step'] = (int) ($oDTRequestIn->get_queryArray()['step'] - 1)
//            : false
//        ;
//
//        $this->setPhormix();
//
//        // make sure action ist just the route path (no query param "step")
//        $this->oPhormix->aConfig['form']['action'] = $oDTRoute->get_path();
//
//        // Form was successfully sent; Validation succeeded
//        if (true === $this->oPhormix->bSuccess)
//        {
//            // save
//            $_SESSION['Chain'][$_SESSION['Chain']['step']]['sFormIdentifier'] = $this->oPhormix->sFormIdentifier;
//            $_SESSION['Chain'][$_SESSION['Chain']['step']]['aData'] = $this->oPhormix->getDataAccepted();
//            $_SESSION['Chain'][$_SESSION['Chain']['step']]['aFiles'] = (false === empty($_FILES)) ? DTFileUpload::create(array_first($_FILES)) : array();
//
//            // call next formular
//            if ($_SESSION['Chain']['step'] < (count($this->oDTPhormixChain->get_aDTPhormixSetup()) - 1))
//            {
//                $_SESSION['Chain']['step']++;
//                $this->setPhormix();
//            }
//        }
    }

//    protected function setPhormix()
//    {
//        $this->oPhormix = Phormix::init(
//            DTPhormixSetup::create()
//                ->set_sConfigYamlFile($this->oDTPhormixChain->get_aDTPhormixSetup()[$_SESSION['Chain']['step']]->get_sConfigYamlFile())
//                ->set_sElementDirectory($this->oDTPhormixChain->get_aDTPhormixSetup()[$_SESSION['Chain']['step']]->get_sElementDirectory())
//                ->set_sValidateClass($this->oDTPhormixChain->get_aDTPhormixSetup()[$_SESSION['Chain']['step']]->get_sValidateClass())
//        );
//
//        // run Phormix
//        $this->oPhormix->run(bResetOnEmpty: false);
//    }

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

        // show config
        $this->showConfigOnDemand($oPhormix);

        // create new captcha text; take identifier from config
        $sCaptchaId = ($oPhormix->aConfig['element']['Captcha']['attribute']['id'] ?? 'Captcha');
        Session::is('Phormix')->set($sCaptchaId, \Phimcap::text());

        if (true === $oPhormix->bSuccess)
        {
            // get Data Array
            $aData = (array_column($_SESSION['Chain'], 'aData') ?? array());

            // get uploaded Files
            $aFiles = current((array_column($_SESSION['Chain'], 'aFiles') ?? array()));

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