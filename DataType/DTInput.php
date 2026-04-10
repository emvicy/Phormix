<?php

/**
 * @name $PhormixDataType
 */
namespace Phormix\DataType;

use MVC\DataType\DTValue;
use MVC\MVCTrait\TraitDataType;

class DTInput
{
	use TraitDataType;

	public const DTHASH = 'f9288eb44aa3747fa9a113b593d086e3';

	/**
	 * @required true
	 * @var \Phormix\Enum\EnumInputTypeValue
	 */
	protected $type;

	/**
	 * @required false
	 * @var \Phormix\Enum\EnumInputAttribute[]
	 */
	protected $attribute;

	/**
	 * DTInput constructor.
	 * @param DTValue $oDTValue
	 * @throws \ReflectionException 
	 */
	protected function __construct(DTValue $oDTValue)
	{
		\MVC\Event::run('DTInput.__construct.before', $oDTValue);
		$aData = $oDTValue->get_mValue();
		$this->type = \Phormix\Enum\EnumInputTypeValue::text;
		$this->attribute = [];
		$this->setProperties($oDTValue);

		$oDTValue = DTValue::create()->set_mValue($aData); 
		\MVC\Event::run('DTInput.__construct.after', $oDTValue);
	}

    /**
     * @param array|null $aData
     * @return DTInput
     * @throws \ReflectionException
     */
    public static function create(?array $aData = array())
    {            
        (null === $aData) ? $aData = array() : false;
        $oDTValue = DTValue::create()->set_mValue($aData);
		\MVC\Event::run('DTInput.create.before', $oDTValue);
		$oObject = new self($oDTValue);
        $oDTValue = DTValue::create()->set_mValue($oObject); \MVC\Event::run('DTInput.create.after', $oDTValue);

        return $oDTValue->get_mValue();
    }

	/**
	 * @param \Phormix\Enum\EnumInputTypeValue $mValue 
	 * @return $this
	 * @throws \ReflectionException
	 */
	public function set_type(\Phormix\Enum\EnumInputTypeValue $mValue)
	{
		$oDTValue = DTValue::create()->set_mValue($mValue); 
		\MVC\Event::run('DTInput.set_type.before', $oDTValue);
		$this->type =  $oDTValue->get_mValue() ;

		return $this;
	}

	/**
	 * @param \Phormix\Enum\EnumInputAttribute[]  $mValue 
	 * @return $this
	 * @throws \ReflectionException
	 */
	public function set_attribute(array $mValue)
	{
		$oDTValue = DTValue::create()->set_mValue($mValue); 
		\MVC\Event::run('DTInput.set_attribute.before', $oDTValue);

		$mValue = (array) $oDTValue->get_mValue();
                
        foreach ($mValue as $mKey => $aData)
        {            
            if (false === ($aData instanceof \Phormix\Enum\EnumInputAttribute))
            {
                $mValue[$mKey] = \Phormix\Enum\EnumInputAttribute::create($aData);
            }
        }

		$this->attribute =  $mValue ;

		return $this;
	}

	/**
	 * @param \Phormix\Enum\EnumInputAttribute $mValue
	 * @return $this
	 * @throws \ReflectionException 
	 */
	public function add_attribute(\Phormix\Enum\EnumInputAttribute $mValue)
	{
		$oDTValue = DTValue::create()->set_mValue($this->attribute); 
		\MVC\Event::run('DTInput.add_attribute.before', $oDTValue);

		$this->attribute[] = $mValue;

		return $this;
	}

	/**
	 * @return \Phormix\Enum\EnumInputTypeValue
	 * @throws \ReflectionException
	 */
	public function get_type() : \Phormix\Enum\EnumInputTypeValue
	{
		$oDTValue = DTValue::create()->set_mValue($this->type); 
		\MVC\Event::run('DTInput.get_type.before', $oDTValue);

		return $oDTValue->get_mValue();
	}

	/**
	 * @return \Phormix\Enum\EnumInputAttribute[]
	 * @throws \ReflectionException
	 */
	public function get_attribute()
	{
		$oDTValue = DTValue::create()->set_mValue($this->attribute); 
		\MVC\Event::run('DTInput.get_attribute.before', $oDTValue);

		return $oDTValue->get_mValue();
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_type()
	{
        return 'type';
	}

	/**
	 * @return string
	 */
	public static function getPropertyName_attribute()
	{
        return 'attribute';
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
