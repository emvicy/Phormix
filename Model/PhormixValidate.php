<?php

namespace Phormix\Model;

use MVC\Session;

class PhormixValidate
{
    /**
	 * validates on minimum length 
     * @param mixed $sFieldValue
     * @param int   $iMinlength
     * @return bool
     */
	public static function _MINLENGTH(mixed $sFieldValue, int $iMinlength) : bool
	{
        if (true === is_array($sFieldValue))
        {
            $sFieldValue = current($sFieldValue);
        }

        if (true === is_string($sFieldValue))
        {
            if (mb_strlen($sFieldValue) < $iMinlength)
            {
                return false;
            }
        }

		return true;
	}
    
    /**
     * validates on maxlength
     * @param mixed $sFieldValue
     * @param int    $iMaxlength
     * @return bool
     */
	public static function _MAXLENGTH(mixed $sFieldValue, int $iMaxlength) : bool
	{
        if (true === is_array($sFieldValue))
        {
            $sFieldValue = current($sFieldValue);
        }

        if (true === is_string($sFieldValue))
        {
            if (mb_strlen($sFieldValue) > $iMaxlength)
            {
                return false;
            }

            return true;
        }

        return false;
	}

    /**
     * validates on expected values
     * @param mixed $sFieldValue
     * @param array $aExpect
     * @return bool
     */
	public static function _EXPECT(mixed $sFieldValue, array $aExpect) : bool
	{
        if (true === is_array($sFieldValue))
        {
            $sFieldValue = current($sFieldValue);
        }

        if (true === is_string($sFieldValue))
        {
            $aValue = array_column($aExpect, 'value');

            if (false === in_array($sFieldValue, $aValue))
            {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * validates by regex pattern
     * @param mixed $sFieldValue
     * @param string $sPattern
     * @return bool
     */
	public static function _REGEX(mixed $sFieldValue, string $sPattern) : bool
	{
        if (true === is_array($sFieldValue))
        {
            $sFieldValue = current($sFieldValue);
        }

        if (true === is_string($sFieldValue))
        {
            return (bool) preg_match($sPattern, $sFieldValue);
        }

        return false;
	}

    /**
     * validates on empty value
     * @param mixed $sFieldValue
     * @param bool  $bEmpty
     * @return bool
     */
	public static function _EMPTY(mixed $sFieldValue, bool $bEmpty) : bool
	{
        if (true === is_array($sFieldValue))
        {
            $sFieldValue = current($sFieldValue);
        }

        if (true === is_string($sFieldValue))
        {
            $bCheck = ('' === $sFieldValue);

            if (false === ($bEmpty === $bCheck))
            {
                return false;
            }

            return true;
        }

        return false;
	}

    /**
     * validates file access
     * @param array $aFiles
     * @return bool
     */
	public static function _FILE(array $aFiles) : bool
	{
		if (false === is_array($aFiles))
		{
			return false;
		}

        // check syntax of $aFile - how it compares to common $_FILES array syntax
        if (false === (0 === count(array_diff(array('name', 'type', 'tmp_name', 'error', 'size'), array_keys($aFiles)))))
        {
			return false;
        }  
        
        // check error
        if (false === (0 === $aFiles['error']))
        {
            return false;
        }
        
		return true;
	}

    /**
     * validates filetype
     * @param array $aFiles
     * @param array $aValid
     * @return bool
     */
	public static function _FILETYPE(array $aFiles, array $aValid) : bool
	{
        if (false === self::_file($aFiles))
        {
            return false;
        }
        
        (false === is_array($aValid))
            ? $aValid = array($aValid)
            : false
        ;
        $sIsFileType = trim(shell_exec('file -bi -- ' . escapeshellarg($aFiles['tmp_name'])));
        
        foreach ($aValid as $sValidFileType)
        {
            if (substr($sIsFileType, 0, strlen($sValidFileType)) == $sValidFileType)
            {
                return true;
            }
        }
                
    	return false;
	}

    /**
     * validates max filesize of file
     * @param array $aFiles
     * @param int   $iMaxfilesize
     * @return bool
     */
	public static function _FILEMAXFILESIZE(array $aFiles, int $iMaxfilesize) : bool
	{
        if (false === self::_file($aFiles))
        {
            return false;
        }
        
        // check size
        if  ($aFiles['size'] > $iMaxfilesize)
        {
            return false;
        }
                
		return true;
	}
    
    /**
     * validates email
     * @param mixed $sFieldValue
     * @param array  $aData
     * @return bool
     */
	public static function _EMAIL(mixed $sFieldValue, array $aData) : bool
	{
        if (true === is_array($sFieldValue))
        {
            $sFieldValue = current($sFieldValue);
        }

        if (true === is_string($sFieldValue))
        {
            return (bool) filter_var($sFieldValue, FILTER_VALIDATE_EMAIL);
        }

        return false;
	}

    /**
     * @param mixed  $sFieldValue
     * @param string $sCaptchaName
     * @return bool
     * @throws \ReflectionException
     */
    public static function _CAPTCHA(mixed $sFieldValue, string $sCaptchaName) : bool
    {
        return (
            $sFieldValue === Session::is('Phormix')->get($sCaptchaName)
        );
    }
}
