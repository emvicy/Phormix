<?php

/**
 * @name $PhormixModel
 */

namespace Phormix\Model;

use MVC\Config;
use MVC\Convert;
use MVC\Debug;
use MVC\Error;
use MVC\Log;
use MVC\Media\Type_Application_json;
use MVC\Media\Type_Text_plain;
use Phormix\DataType\DTPhormixSetup;
use Symfony\Component\Yaml\Yaml;

/**
 *
 */
class Phormix
{
    /**
     * @var \Phormix\Model\Phormix[]
     */
    protected static $_aInstance = [];

    /**
     * @var \Phormix\DataType\DTPhormixSetup
     */
    protected $_oDTPhormixSetup;

    /**
     * @var string
     */
    protected $_sPrefix = 'Phormix';

    /**
     * @var array
     */
    protected $_aMissing = array();

    /**
     * @var array
     */
    protected $_aError = array();

    /**
     * @var mixed
     */
    public $aConfig;

    /**
     * @var string
     */
    public $sFormIdentifier;

    /**
     * @var
     */
    public $sTicket;

    /**
     * @var bool
     */
    public $bSent = false;

    /**
     * @var bool
     */
    public $bSuccess = false;

    #-------------------------------------------------------------------------------------------------------------------
    # protected

    protected function __clone() { }

    /**
     * @param \Phormix\DataType\DTPhormixSetup $oDTPhormixSetup
     * @throws \ReflectionException
     */
    protected function __construct(DTPhormixSetup $oDTPhormixSetup)
    {
        $this->_oDTPhormixSetup = $oDTPhormixSetup;
        $this->aConfig = $this->loadConfigYaml();
        $this->sFormIdentifier = md5(json_encode($this->aConfig));
    }

    /**
     * @return array|mixed
     */
    protected function _getFormDataSentArray()
    {
        // get data sent by form
        return ($GLOBALS['_' . strtoupper( ($this->aConfig['form']['method'] ?? 'post') )] ?? array());
    }

    /**
     * @param array $aData formular data array which was sent
     * @return bool success
     * @throws \ReflectionException
     */
    protected function _check($aData, bool $bResetOnEmpty = true)
    {
        // ticket
        if (true === empty(($aData[$this->_getSessionInfo('sTicket')] ?? '')))
        {
            if (true === $bResetOnEmpty)
            {
                $this->reset(bForce: true);
            }

            return false;
        }

        // remove ticket + formidentifier from sent data array
        unset($aData[$this->_getSessionInfo('sTicket')]);
        unset($aData[$this->sFormIdentifier]);

        // walk elements
        foreach ($this->aConfig['element'] as $iKey => $aElement)
        {
            $aAttribute = ($aElement['attribute'] ?? array());
            $sAttributeName = ($aAttribute['name'] ?? '');
            $sAttributeName = str_replace(['[', ']'], '', $sAttributeName);
            $bRequired = ($aAttribute['required'] ?? false);
            $aValidate = ($aElement['filter']['validate'] ?? array());
            $aSanitize = ($aElement['filter']['sanitize'] ?? array());

            // element which is declared as "required" was not sent; so it is "missing"
            if	(true === $bRequired && false === array_key_exists(($aAttribute['name'] ?? uniqid()), $aData))
            {
                $this->_aMissing[$sAttributeName] = '`' . $aElement['label'] . '` is required.';

                return false;
            }

            /**
             * @example
             *          $sKey  : "minLength" (array)
             *          $aValue: 5
             */
            foreach ($aValidate as $sKey => $aValue)
            {
                // e.g. `_minLength`
                $sValidateMethod = strtoupper('_' . $sKey);
                $bElementIsValid = true;

                if (array_key_exists('value', $aValue))
                {
                    // either it is required
                    // or it is not but then there has to be a value that can be checked
                    if (true === $bRequired || (false === $bRequired && false === empty($aData[$sAttributeName])))
                    {
                        $sValidateClass = $this->_oDTPhormixSetup->get_sValidateClass();
                        $bElementIsValid = $sValidateClass::$sValidateMethod(
                            $aData[$sAttributeName],
                            $aValue['value']
                        );
                    }

                    // take "element.label" or "element.attribute.name"
                    $sElementIdentifier = (array_key_exists('label', $aElement))
                        ? $aElement['label']
                        : $sAttributeName
                    ;

                    // validation fail
                    if (false === $bElementIsValid)
                    {
                        // add error
                        $this->_aError[$sAttributeName] = (array_key_exists('fail', ($aValue['message'] ?? array())))
                            ? '"' . $sElementIdentifier . '": ' . sprintf($aValue['message']['fail'], $aValue['value'])
                            : '`' . $aElement['label'] . '` is invalid.'
                        ;
                        Log::write("FAIL\t" . 'Validate ' . $sValidateMethod . '(' . json_encode($aData[$sAttributeName]) . ', ' . json_encode($aValue['value']) . ')' . ' [attribute.name: ' . $sAttributeName . ']', 'phormix.log');

                        return false;
                    }
                    // validation success
                    elseif (true === $bElementIsValid)
                    {
                        // add message
                        $this->_aMessage[$sAttributeName]['validate'][$sValidateMethod] =  (array_key_exists('success', ($aValue['message'] ?? array())))
                            ? '"' . $sElementIdentifier . '": ' . sprintf($aValue['message']['success'], $aValue['value'])
                            : '`' . $aElement['label'] . '` is valid.'
                        ;
                        Log::write("SUCCESS\t" . 'Validate ' . $sValidateMethod . '(' . json_encode($aData[$sAttributeName]) . ', ' . json_encode($aValue['value']) . ')' . ' [attribute.name: ' . $sAttributeName . ']', 'phormix.log');
                    }
                }
                else
                {
                    Log::write("FAIL\t" . 'Element with label `' . $aElement['label'] . '`is missing "value" in validate config `' . $sKey . '`: ' . json_encode($aValue), 'phormix.log');
                }
            }
        }

        #----------
        # success

        // save Data into session
        $this->_setSessionInfo(sKey: 'aData', mValue: $aData);
        $this->_setSessionInfo(sKey: 'aFiles', mValue: $_FILES);

        return true;
    }

    /**
     * @param string $sTicket
     * @return void
     * @throws \ReflectionException
     */
    protected function _setTicket(string $sTicket = '')
    {
        $this->sTicket = (true === empty($sTicket))
            ? Config::get_MVC_UNIQUE_ID()
            : $sTicket
        ;
    }

    /**
     * saves infos into session: ticket
     * @return void
     */
    protected function _setSessionInfo(string $sKey, mixed $mValue)
    {
        (false === isset($_SESSION[$this->_sPrefix]))
            ? $_SESSION[$this->_sPrefix] = array()
            : false
        ;
        (false === isset($_SESSION[$this->_sPrefix][$this->sFormIdentifier]))
            ? $_SESSION[$this->_sPrefix][$this->sFormIdentifier] = array()
            : false
        ;

        // save
        $_SESSION[$this->_sPrefix][$this->sFormIdentifier][$sKey] = $mValue;
    }

    /**
     * @param string $sKey
     * @return mixed|null
     */
    protected function _getSessionInfo(string $sKey)
    {
        return ($_SESSION[$this->_sPrefix][$this->sFormIdentifier][$sKey] ?? null);
    }

    /**
     * @param string $sYamlFile
     * @return array
     * @throws \ReflectionException
     */
    protected function loadConfigYaml(string $sYamlFile = '')
    {
        if (true === empty($sYamlFile))
        {
            $sYamlFile = $this->_oDTPhormixSetup->get_sConfigYamlFile();
        }

        $sYaml = '';
        $sYaml.= '# ' . $sYamlFile . PHP_EOL;
        $sYaml.= file_get_contents($sYamlFile) . PHP_EOL;

        try {
            $aConfigFormularYaml = (array) Yaml::parseFile($sYamlFile);
        } catch (\Exception $oException) {
            Error::exception($oException);
            Debug::stop(
                'unable to parse YAML file: ' . $sYamlFile, false, false
            );
        }

        // cut off element
        $sYaml = substr($sYaml, 0, strpos($sYaml, 'element:'));
        $sYaml.= 'element:' . PHP_EOL;

        foreach (($aConfigFormularYaml['element'] ?? []) as $sElement)
        {
            $sYamlFileSub = $this->_oDTPhormixSetup->get_sElementDirectory() . $sElement . '.yaml';
            $sYaml.= PHP_EOL . "\t" . '# ' . $sYamlFileSub . PHP_EOL;
            $sYaml.= "\t" . $sElement . ':' . PHP_EOL;
            $rFile = fopen($sYamlFileSub, "r");

            if ($rFile)
            {
                while ($sLine = fgets($rFile))
                {
                    $sYaml.= "\t\t" . $sLine;
                }

                fclose($rFile);
            }

            $sYaml = str_replace("\t", '  ', $sYaml); # remove, because \t won't work
        }

        try {
            $aConfigFinal = (array) Yaml::parse($sYaml);
        } catch (\Exception $oException) {
            Error::exception($oException);
            Debug::stop(
                $oException->getMessage(), false, false
            );
        }

        return ($aConfigFinal ?? array());
    }

    #-------------------------------------------------------------------------------------------------------------------
    # public

    /**
     * @param \Phormix\DataType\DTPhormixSetup $oDTPhormixSetup
     * @return \Phormix\Model\Phormix|self
     * @throws \ReflectionException
     */
    public static function init(DTPhormixSetup $oDTPhormixSetup)
    {
        $sKey = md5(Convert::serialize($oDTPhormixSetup));

        if (false === array_key_exists($sKey, self::$_aInstance))
        {
            /** Phormix self::$_aInstance[$sKey] */
            self::$_aInstance[$sKey] = new self($oDTPhormixSetup);
        }

        return self::$_aInstance[$sKey];
    }

    /**
     * @param bool $bResetOnEmpty
     * @return $this
     * @throws \ReflectionException
     */
    public function run(bool $bResetOnEmpty = true)
    {
        $aData = $this->_getFormDataSentArray();

        // check Data
        if (false === empty($aData))
        {
            $this->bSent = true;
            $this->bSuccess = $this->_check($aData, $bResetOnEmpty);
        }

        // generate new ticket for current request
        $this->_setTicket();

        // save to session
        $this->_setSessionInfo(sKey: 'sTicket', mValue: $this->sTicket);

        // overwrite global
        $GLOBALS['_' . strtoupper( ($this->aConfig['form']['method'] ?? 'post') )] = $this->_getFormDataSentArray();

        return $this;
    }

    /**
     * @return \MVC\Asset[]
     */
    public function getInstancesArray()
    {
        return self::$_aInstance;
    }

    /**
     * returns the raw data as sent by form
     * @return mixed|null
     */
    public function getDataSent()
    {
        $sMethod = strtoupper($this->aConfig['form']['method'] ?? '');

        return ($GLOBALS['_' . $sMethod] ?? null);
    }

    /**
     * returns array with errors on form elements
     * @return array
     */
    public function getErrorArray()
    {
        return $this->_aError;
    }

    /**
     * returns array with missing form elements which were not sent by form but are required by config
     * @return array
     */
    public function getMissingArray()
    {
        return $this->_aMissing;
    }

    /**
     * returns validated|sanitized data from form, ready to process
     * @return array
     */
    public function getDataAccepted()
    {
        return ($this->_getSessionInfo('aData') ?? array());
    }

    /**
     * @return array|mixed
     */
    public function getFilesAccepted()
    {
        return ($this->_getSessionInfo('aFiles') ?? array());
    }

    /**
     * delete sent data from formular in globals.
     * if bForce is true: accepted data in session (result) will also be deleted
     * @return void
     */
    public function reset(bool $bForce = false)
    {
        unset($GLOBALS['_' . strtoupper( ($this->aConfig['form']['method'] ?? 'post') )]);

        if (true === $bForce && true === isset($_SESSION[$this->_sPrefix][$this->sFormIdentifier]))
        {
            unset($_SESSION[$this->_sPrefix][$this->sFormIdentifier]);
        }
    }

    /**
     * @return \Phormix\DataType\DTPhormixSetup
     */
    public function getDTPhormixSetup()
    {
        return $this->_oDTPhormixSetup;
    }

    /**
     * @param bool $bReturn
     * @return false|string|void
     */
    public function getFinalConfigAsJson(bool $bReturn = true)
    {
        if (false === $bReturn)
        {
            Type_Application_json::header();
            echo json_encode($this->aConfig);
            exit();
        }

        return json_encode($this->aConfig);
    }

    /**
     * @param bool $bReturn
     * @return false|string|void
     */
    public function getFinalConfigAsPhp(bool $bReturn = true)
    {
        if (false === $bReturn)
        {
            Type_Text_plain::header();
            echo Debug::varExport($this->aConfig, true);
            exit();
        }

        return json_encode($this->aConfig);
    }

    /**
     * @param bool $bReturn
     * @return false|string|void
     */
    public function getFinalConfigAsYaml(bool $bReturn = true)
    {
        if (false === $bReturn)
        {
            Type_Text_plain::header();
            echo Yaml::dump($this->aConfig, 10, 4);
            exit();
        }

        return json_encode($this->aConfig);
    }

    #-------------------------------------------------------------------------------------------------------------------
    # template helper

    /**
     * @return string
     */
    public function getMarkupFormAttributes()
    {
        $sAttributes = '';

        foreach ($this->aConfig['form'] as $sAttribute => $sValue)
        {
            $sAttributes.= ' ' . $sAttribute . '="' . $sValue. '"';
        }

        return $sAttributes;
    }

    /**
     * @return string
     */
    public function getMarkupTicket()
    {
        return '<input type="hidden" name="' . $this->sTicket . '" value="' . $this->sTicket . '" required>';
    }

    /**
     * @return string
     */
    public function getMarkupFormIdentifier()
    {
        return '<input type="hidden" name="' . $this->sFormIdentifier . '" value="' . $this->sFormIdentifier . '" required>';
    }
}