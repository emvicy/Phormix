<?php

/**
 * @name $PhormixDataType
 */
namespace Phormix\DataType;

use MVC\DataType\DTValue;
use MVC\MVCTrait\TraitDataType;

class DTPhormixSetup
{
	use TraitDataType;

	public const DTHASH = 'a5662b2d0c284e610f4c0a3ed33fd8f3';

	/**
	 * @required true
	 * @var string
	 */
	protected $sLabel;

	/**
	 * @required true
	 * @var string
	 */
	protected $sElementDirectory;

	/**
	 * @required true
	 * @var string
	 */
	protected $sConfigYamlFile;

	/**
	 * @required true
	 * @var string
	 */
	protected $sValidateClass;

	/**
	 * DTPhormixSetup constructor.
	 * @param DTValue $oDTValue
	 * @throws \ReflectionException 
	 */
	protected function __construct(DTValue $oDTValue)
	{
		\MVC\Event::run('DTPhormixSetup.__construct.before', $oDTValue);
		$aData = $oDTValue->get_mValue();
		$this->sLabel = null;
		$this->sElementDirectory = null;
		$this->sConfigYamlFile = null;
		$this->sValidateClass = null;
		$this->setProperties($oDTValue);

		$oDTValue = DTValue::create()->set_mValue($aData); 
		\MVC\Event::run('DTPhormixSetup.__construct.after', $oDTValue);
	}

    /**
     * @param array|null $aData
     * @return DTPhormixSetup
     * @throws \ReflectionException
     */
    public static function create(?array $aData = array())
    {            
        (null === $aData) ? $aData = array() : false;
        $oDTValue = DTValue::create()->set_mValue($aData);
		\MVC\Event::run('DTPhormixSetup.create.before', $oDTValue);
		$oObject = new self($oDTValue);
        $oDTValue = DTValue::create()->set_mValue($oObject); \MVC\Event::run('DTPhormixSetup.create.after', $oDTValue);

        return $oDTValue->get_mValue();
    }

	/**
	 * @param string $mValue 
	 * @return $this
	 * @throws \ReflectionException
	 */
	public function set_sLabel(string $mValue)
	{
		$oDTValue = DTValue::create()->set_mValue($mValue); 
		\MVC\Event::run('DTPhormixSetup.set_sLabel.before', $oDTValue);
		$this->sLabel =  (string) $oDTValue->get_mValue() ;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 * @throws \ReflectionException
	 */
	public function set_sElementDirectory(string $mValue)
	{
		$oDTValue = DTValue::create()->set_mValue($mValue); 
		\MVC\Event::run('DTPhormixSetup.set_sElementDirectory.before', $oDTValue);
		$this->sElementDirectory =  (string) $oDTValue->get_mValue() ;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 * @throws \ReflectionException
	 */
	public function set_sConfigYamlFile(string $mValue)
	{
		$oDTValue = DTValue::create()->set_mValue($mValue); 
		\MVC\Event::run('DTPhormixSetup.set_sConfigYamlFile.before', $oDTValue);
		$this->sConfigYamlFile =  (string) $oDTValue->get_mValue() ;

		return $this;
	}

	/**
	 * @param string $mValue 
	 * @return $this
	 * @throws \ReflectionException
	 */
	public function set_sValidateClass(string $mValue)
	{
		$oDTValue = DTValue::create()->set_mValue($mValue); 
		\MVC\Event::run('DTPhormixSetup.set_sValidateClass.before', $oDTValue);
		$this->sValidateClass =  (string) $oDTValue->get_mValue() ;

		return $this;
	}

	/**
	 * @return string
	 * @throws \ReflectionException
	 */
	public function get_sLabel() : string
	{
		$oDTValue = DTValue::create()->set_mValue($this->sLabel); 
		\MVC\Event::run('DTPhormixSetup.get_sLabel.before', $oDTValue);

		return $oDTValue->get_mValue();
	}

	/**
	 * @return string
	 * @throws \ReflectionException
	 */
	public function get_sElementDirectory() : string
	{
		$oDTValue = DTValue::create()->set_mValue($this->sElementDirectory); 
		\MVC\Event::run('DTPhormixSetup.get_sElementDirectory.before', $oDTValue);

		return $oDTValue->get_mValue();
	}

	/**
	 * @return string
	 * @throws \ReflectionException
	 */
	public function get_sConfigYamlFile() : string
	{
		$oDTValue = DTValue::create()->set_mValue($this->sConfigYamlFile); 
		\MVC\Event::run('DTPhormixSetup.get_sConfigYamlFile.before', $oDTValue);

		return $oDTValue->get_mValue();
	}

	/**
	 * @return string
	 * @throws \ReflectionException
	 */
	public function get_sValidateClass() : string
	{
		$oDTValue = DTValue::create()->set_mValue($this->sValidateClass); 
		\MVC\Event::run('DTPhormixSetup.get_sValidateClass.before', $oDTValue);

		return $oDTValue->get_mValue();
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sLabel()
	{
        return 'sLabel';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sElementDirectory()
	{
        return 'sElementDirectory';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sConfigYamlFile()
	{
        return 'sConfigYamlFile';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_sValidateClass()
	{
        return 'sValidateClass';
	}

	/**
	 * @return false|string JSON
	 */
	public function __toString()
	{
        return $this->getPropertyJson();
	}

	/**
	 * @return false|string
	 */
	public function getPropertyJson()
	{
        return json_encode(\MVC\Convert::objectToArray($this));
	}

	/**
	 * @return array
	 */
	public function getPropertyArray()
	{
        return get_object_vars($this);
	}

	/**
	 * @return array
	 * @throws \ReflectionException
	 */
	public function getConstantArray()
	{
		$oReflectionClass = new \ReflectionClass($this);
		$aConstant = $oReflectionClass->getConstants();

		return $aConstant;
	}

	/**
	 * @return $this
	 */
	public function flushProperties()
	{
		foreach ($this->getPropertyArray() as $sKey => $mValue)
		{
			$sMethod = 'set_' . $sKey;

			if (method_exists($this, $sMethod)) 
			{
				$this->$sMethod('');
			}
		}

		return $this;
	}

}
