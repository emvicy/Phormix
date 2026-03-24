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
use Symfony\Component\Yaml\Yaml;

/**
 *
 */
class Phormix
{
    /**
     * @var self|null
     */
    protected static $_oInstance = null;

    /**
     * @var string
     */
    protected $_sPrefix = 'Phormix';

    /**
     * @var string
     */
    protected $_sElementDirectory = '';

    /**
     * @var array
     */
    protected $_aMissing = array();

    /**
     * @var array
     */
    protected $_aError = array();

    /**
     * @var string
     */
    protected $_sValidateClass = '\Phormix\Model\PhormixValidate';

    /**
     * @var string
     */
    protected $_sSanitizeClass = '\Phormix\Model\PhormixSanitize';

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

    /**
     * @param string $sYamlFile
     * @param string $sElementFolder
     * @throws \ReflectionException
     */
    protected function __construct()
    {
        $this->setElementDirectory(realpath(__DIR__ . '/../') . '/element/');
    }

    /**
     * @return array|mixed
     */
    protected function _getFormDataSentArray()
    {
        // get data sent by form
        return $GLOBALS['_' . strtoupper( ($this->aConfig['form']['method'] ?? 'post') )];
    }

    /**
     * @param array $aData formular data array which was sent
     * @return bool success
     * @throws \ReflectionException
     */
    protected function _check($aData)
    {
        Log::write($aData, 'phormix.log');

        // ticket
        if (
            true === empty(($aData[$this->_getSessionInfo('sTicket')] ?? '')) ||
            false === ($aData[$this->_getSessionInfo('sTicket')] === $aData[$this->_getSessionInfo('sTicket')])
        )
        {
            return false;
        }

        // walk elements
        foreach ($this->aConfig['element'] as $iKey => $aElement)
        {
            $aAttribute = ($aElement['attribute'] ?? array());
            $sAttributeName = ($aAttribute['name'] ?? '');
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

                if (array_key_exists('value', $aValue))
                {
                    // either it is required, or it is not but then there has to be a value
                    if (true === $bRequired || (false === $bRequired && false === empty($aData[$sAttributeName])))
                    {
                        $bElementIsValid = $this->_sValidateClass::$sValidateMethod(
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
                        $this->_aError[$sAttributeName] =  (array_key_exists('fail', ($aValue['message'] ?? array())))
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

//        foreach ($aSanitize as $sKey => $aValue)
//        {
//
//        }

        #----------
        # success

        // save positive checked Data into session
        $this->_setSessionInfo(sKey: 'aData', mValue: $aData);

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

    #-------------------------------------------------------------------------------------------------------------------
    # public

    /**
     * @return \Phormix\Model\Phormix|self|null
     */
    public static function init()
    {
        if (null === self::$_oInstance)
        {
            self::$_oInstance = new self();
        }

        return self::$_oInstance;
    }

    /**
     * @param string $sElementDirectory
     * @return $this
     */
    public function setElementDirectory(string $sElementDirectory)
    {
        $this->_sElementDirectory = $sElementDirectory;

        return $this;
    }

    /**
     * @param string $sYamlFile
     * @return $this
     * @throws \ReflectionException
     */
    public function loadConfigYaml(string $sYamlFile)
    {
        $sYaml = '';
        $sYaml.= '# ' . $sYamlFile . PHP_EOL;
        $sYaml.= file_get_contents($sYamlFile) . PHP_EOL;

        try {
            $aConfig = Yaml::parseFile($sYamlFile);
        } catch (\Exception $oException) {
            Error::exception($oException);
            Debug::stop(
                'unable to parse YAML file: ' . $sYamlFile, false, false
            );
        }

        // cut off element
        $sYaml = substr($sYaml, 0, strpos($sYaml, 'element:'));
        $sYaml.= 'element:' . PHP_EOL;

        foreach ($aConfig['element'] as $sElement)
        {
            $sYamlFileSub = $this->_sElementDirectory . $sElement . '.yaml';
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

            $sYaml = str_replace("\t", '  ', $sYaml); # \t wont work
        }

        try {
            $this->aConfig = Yaml::parse($sYaml);
        } catch (\Exception $oException) {
            Error::exception($oException);
            Debug::stop(
                $oException->getMessage(), false, false
            );
        }

        $this->sFormIdentifier = md5(Convert::serialize($this->aConfig));

        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function run()
    {
        $aData = $this->_getFormDataSentArray();

        // check Data
        if (false === empty($aData))
        {
            $this->bSent = true;
            $this->bSuccess = $this->_check($aData);
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
     * @param string $sClass
     * @return $this
     */
    public function setValidateClass(string $sClass)
    {
        $this->_sValidateClass = $sClass;

        return $this;
    }

    /**
     * @param string $sSanitizeClass
     * @return $this
     */
    public function setSanitizeClass(string $sSanitizeClass)
    {
        $this->_sSanitizeClass = $sSanitizeClass;

        return $this;
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