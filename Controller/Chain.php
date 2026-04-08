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
use Phormix\Model\Phormix;


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

        // declare chained forms
        $this->aChain = array(
            1 => array(
                'label' => 'Name / Company',
                'yaml' => Config::get_MVC_MODULES_DIR() . '/Phormix/chain1.yaml',
            ),
            2 => array(
                'label' => 'Address',
                'yaml' => Config::get_MVC_MODULES_DIR() . '/Phormix/chain2.yaml',
            ),
            3 => array(
                'label' => 'Submit data',
                'yaml' => Config::get_MVC_MODULES_DIR() . '/Phormix/chain3.yaml',
            ),
        );

        (false === isset($_SESSION['Chain']['step']))
            ? $_SESSION['Chain']['step'] = 1
            : false
        ;

        // jump between forms
        (false === empty($oDTRequestIn->get_queryArray()['step'] ?? ''))
            ? $_SESSION['Chain']['step'] = (int) $oDTRequestIn->get_queryArray()['step']
            : false
        ;

        $this->setPhormix();

        // Form was successfully sent; Validation succeeded
        if (true === $this->oPhormix->bSuccess)
        {
            // save
            $_SESSION['Chain'][$_SESSION['Chain']['step']]['sFormIdentifier'] = $this->oPhormix->sFormIdentifier;
            $_SESSION['Chain'][$_SESSION['Chain']['step']]['aData'] = $this->oPhormix->getDataAccepted();
            $_SESSION['Chain'][$_SESSION['Chain']['step']]['aFiles'] = (false === empty($_FILES)) ? DTFileUpload::create(array_first($_FILES)) : array();

            // go to next formular
            if ($_SESSION['Chain']['step'] < count($this->aChain))
            {
                $_SESSION['Chain']['step']++;

                $this->setPhormix();
            }
        }
    }

    protected function setPhormix()
    {
        $this->oPhormix = Phormix::init(array(
            'sElementDirectory' => Config::get_MVC_MODULES_DIR() . '/Phormix/element/',
            'sConfigYamlFile' => $this->aChain[$_SESSION['Chain']['step']]['yaml'],
            'sValidateClass' => '\Phormix\Model\PhormixValidate',
        ));

        // run Phormix
        $this->oPhormix->run();
    }

    /**
     * @param \MVC\DataType\DTRequestIn $oDTRequestIn
     * @param \MVC\DataType\DTRoute     $oDTRoute
     * @return void
     * @throws \ReflectionException
     */
    public function formular(DTRequestIn $oDTRequestIn, DTRoute $oDTRoute)
    {
        // show config
        $this->showConfigOnDemand($this->oPhormix);

        info(
            $this->oPhormix
        );
        info(
            $_SESSION
        );

        // create new captcha text; take identifier from config
        $sCaptchaId = ($this->oPhormix->aConfig['element']['Captcha']['attribute']['id'] ?? 'Captcha');
        Session::is('Phormix')->set($sCaptchaId, \Phimcap::text());

        if (true === $this->oPhormix->bSuccess)
        {
            info(
                array_column($_SESSION['Chain'], 'aData')
            );
            info(
                array_column($_SESSION['Chain'], 'aFiles')
            );
        }

        view()->assign('oPhormix', $this->oPhormix);
        view()->assign('oDTRoute', $oDTRoute);
        view()->assign('aFiles', $_FILES);
        view()->assign('aChain', $this->aChain);
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