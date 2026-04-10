<?php

namespace Phormix\Model;

use MVC\DataType\DTRequestIn;
use MVC\DataType\DTRoute;
use Phormix\DataType\DTPhormixChain;
use Phormix\DataType\DTPhormixSetup;

class PhormixChain
{
    /**
     * @var string
     */
    protected $_sPrefix = 'Phormix';

    /**
     * @var DTPhormixChain
     */
    protected $oDTPhormixChain;

    /**
     * @return void
     */
    protected function setStep()
    {
        (false === isset($_SESSION[$this->_sPrefix]['ChainStep']))
            ? $_SESSION[$this->_sPrefix]['ChainStep'] = 0
            : false
        ;
    }

    /**
     * @param \MVC\DataType\DTRequestIn $oDTRequestIn
     * @return void
     * @throws \ReflectionException
     */
    protected function jumpForms(DTRequestIn $oDTRequestIn)
    {
        // jump between forms by query param "step"
        (false === empty($oDTRequestIn->get_queryArray()['step'] ?? ''))
            ? $_SESSION[$this->_sPrefix]['ChainStep'] = (int) ($oDTRequestIn->get_queryArray()['step'] - 1)
            : false
        ;
    }

    /**
     * @param string $sKey
     * @return mixed|null
     */
    protected function _getSessionInfo(string $sKey)
    {
        return ($_SESSION[$this->_sPrefix][$sKey] ?? null);
    }

    #-------------------------------------------------------------------------------------------------------------------
    # public

    /**
     * @param \MVC\DataType\DTRequestIn        $oDTRequestIn
     * @param \Phormix\DataType\DTPhormixChain $oDTPhormixChain
     * @throws \ReflectionException
     */
    public function __construct(DTRequestIn $oDTRequestIn, DTPhormixChain $oDTPhormixChain)
    {
        $this->oDTPhormixChain = $oDTPhormixChain;
        $this->setStep();
        $this->jumpForms($oDTRequestIn);
    }

    /**
     * @return mixed
     */
    public function getStep()
    {
        $this->setStep();
        return $_SESSION[$this->_sPrefix]['ChainStep'];
    }

    /**
     * @return array
     */
    public function getDataAccepted()
    {
        return (array_column($this->_getSessionInfo('Chain'), 'aData') ?? array());
    }

    /**
     * @return array
     */
    public function getFilesAccepted()
    {
        return current(array_column($this->_getSessionInfo('Chain'), 'aFiles') ?? array());
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->_sPrefix;
    }

    /**
     * @return \Phormix\Model\Phormix
     * @throws \ReflectionException
     */
    public function getPhormix()
    {
        $oPhormix = Phormix::init(
            DTPhormixSetup::create()
                ->set_sConfigYamlFile($this->oDTPhormixChain->get_aDTPhormixSetup()[$_SESSION[$this->_sPrefix]['ChainStep']]->get_sConfigYamlFile())
                ->set_sElementDirectory($this->oDTPhormixChain->get_aDTPhormixSetup()[$_SESSION[$this->_sPrefix]['ChainStep']]->get_sElementDirectory())
                ->set_sValidateClass($this->oDTPhormixChain->get_aDTPhormixSetup()[$_SESSION[$this->_sPrefix]['ChainStep']]->get_sValidateClass())
        );

        $oPhormix->run(bResetOnEmpty: false);

        return $oPhormix;
    }

    /**
     * @param \MVC\DataType\DTRoute  $oDTRoute
     * @param \Phormix\Model\Phormix $oPhormix
     * @return \Phormix\Model\Phormix
     * @throws \ReflectionException
     */
    public function setActionOnRoutePath(DTRoute $oDTRoute, Phormix $oPhormix)
    {
        // make sure action ist just the route path (no query param "step")
        $oPhormix->aConfig['form']['action'] = $oDTRoute->get_path();

        return $oPhormix;
    }

    /**
     * @param \Phormix\Model\Phormix $oPhormix
     * @return \Phormix\Model\Phormix
     * @throws \ReflectionException
     */
    public function proceed(Phormix $oPhormix)
    {
        // Form was successfully sent; Validation succeeded
        if (true === $oPhormix->bSuccess)
        {
            // save
            $_SESSION[$this->_sPrefix]['Chain'][$_SESSION[$this->_sPrefix]['ChainStep']]['sFormIdentifier'] = $oPhormix->sFormIdentifier;
            $_SESSION[$this->_sPrefix]['Chain'][$_SESSION[$this->_sPrefix]['ChainStep']]['aData'] = $oPhormix->getDataAccepted();
            $_SESSION[$this->_sPrefix]['Chain'][$_SESSION[$this->_sPrefix]['ChainStep']]['bSuccess'] = true;
            (false === empty($_FILES)) ? $_SESSION[$this->_sPrefix]['Chain'][$_SESSION[$this->_sPrefix]['ChainStep']]['aFiles'] = $_FILES : false;

            // soft reset (e.g. $_POST data only)
            $oPhormix->reset();

            // call next formular
            if ($_SESSION[$this->_sPrefix]['ChainStep'] < (count($this->oDTPhormixChain->get_aDTPhormixSetup()) - 1))
            {
                $_SESSION[$this->_sPrefix]['ChainStep']++;
                $oPhormix = $this->getPhormix();
            }
        }

        return $oPhormix;
    }

    /**
     * @param \Phormix\Model\Phormix $oPhormix
     * @return void
     */
    public function reset(Phormix $oPhormix)
    {
        unset($_SESSION[$this->_sPrefix]['ChainStep']);
        unset($_SESSION[$this->_sPrefix]['Chain']);

        // hard reset (e.g. $_POST data + $_SESSION[$this->_sPrefix] data)
        $oPhormix->reset(bForce: true);
    }
}