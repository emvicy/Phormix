<?php

/**
 * @name $PhormixDataType
 */
namespace Phormix\DataType;

use MVC\DataType\DTValue;
use MVC\MVCTrait\TraitDataType;

class DTPhormixChain
{
	use TraitDataType;

	public const DTHASH = '965bd07746072377594e41446b8c3348';

	/**
	 * @required true
	 * @var \Phormix\DataType\DTPhormixSetup[]
	 */
	protected $aDTPhormixSetup;

	/**
	 * DTPhormixChain constructor.
	 * @param DTValue $oDTValue
	 * @throws \ReflectionException 
	 */
	protected function __construct(DTValue $oDTValue)
	{
		\MVC\Event::run('DTPhormixChain.__construct.before', $oDTValue);
		$aData = $oDTValue->get_mValue();
		$this->aDTPhormixSetup = [];
		$this->setProperties($oDTValue);

		$oDTValue = DTValue::create()->set_mValue($aData); 
		\MVC\Event::run('DTPhormixChain.__construct.after', $oDTValue);
	}

    /**
     * @param array|null $aData
     * @return DTPhormixChain
     * @throws \ReflectionException
     */
    public static function create(?array $aData = array())
    {            
        (null === $aData) ? $aData = array() : false;
        $oDTValue = DTValue::create()->set_mValue($aData);
		\MVC\Event::run('DTPhormixChain.create.before', $oDTValue);
		$oObject = new self($oDTValue);
        $oDTValue = DTValue::create()->set_mValue($oObject); \MVC\Event::run('DTPhormixChain.create.after', $oDTValue);

        return $oDTValue->get_mValue();
    }

	/**
	 * @param \Phormix\DataType\DTPhormixSetup[]  $mValue 
	 * @return $this
	 * @throws \ReflectionException
	 */
	public function set_aDTPhormixSetup(array $mValue)
	{
		$oDTValue = DTValue::create()->set_mValue($mValue); 
		\MVC\Event::run('DTPhormixChain.set_aDTPhormixSetup.before', $oDTValue);

		$mValue = (array) $oDTValue->get_mValue();
                
        foreach ($mValue as $mKey => $aData)
        {            
            if (false === ($aData instanceof \Phormix\DataType\DTPhormixSetup))
            {
                $mValue[$mKey] = \Phormix\DataType\DTPhormixSetup::create($aData);
            }
        }

		$this->aDTPhormixSetup =  $mValue ;

		return $this;
	}

	/**
	 * @param \Phormix\DataType\DTPhormixSetup $mValue
	 * @return $this
	 * @throws \ReflectionException 
	 */
	public function add_aDTPhormixSetup(\Phormix\DataType\DTPhormixSetup $mValue)
	{
		$oDTValue = DTValue::create()->set_mValue($this->aDTPhormixSetup); 
		\MVC\Event::run('DTPhormixChain.add_aDTPhormixSetup.before', $oDTValue);

		$this->aDTPhormixSetup[] = $mValue;

		return $this;
	}

	/**
	 * @return \Phormix\DataType\DTPhormixSetup[]
	 * @throws \ReflectionException
	 */
	public function get_aDTPhormixSetup()
	{
		$oDTValue = DTValue::create()->set_mValue($this->aDTPhormixSetup); 
		\MVC\Event::run('DTPhormixChain.get_aDTPhormixSetup.before', $oDTValue);

		return $oDTValue->get_mValue();
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_aDTPhormixSetup()
	{
        return 'aDTPhormixSetup';
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
