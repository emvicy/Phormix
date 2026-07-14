<?php

namespace Phormix\Model;

use MVC\Session;

class PhormixValidate
{
    /**
	 * validates on minimum length 
     * @param mixed $mFieldValue
     * @param int   $iMinlength
     * @return bool
     */
	public static function _MINLENGTH(mixed $mFieldValue, int $iMinlength) : bool
	{
        $cClosure = function($sFieldValue) use ($iMinlength) {
            return (mb_strlen($sFieldValue) < $iMinlength);
        };

        if (true === is_array($mFieldValue))
        {
            foreach ($mFieldValue as $sFieldValue)
            {
                if (true === $cClosure($sFieldValue))
                {
                    return false;
                }
            }
        }

        if (true === is_string($mFieldValue))
        {
            if (true === $cClosure($mFieldValue))
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
	public static function _MAXLENGTH(mixed $mFieldValue, int $iMaxlength) : bool
	{
        $cClosure = function($sFieldValue) use ($iMaxlength) {
            return (mb_strlen($sFieldValue) > $iMaxlength);
        };

        if (true === is_array($mFieldValue))
        {
            foreach ($mFieldValue as $sFieldValue)
            {
                if (true === $cClosure($sFieldValue))
                {
                    return false;
                }
            }
        }

        if (true === is_string($mFieldValue))
        {
            if (true === $cClosure($mFieldValue))
            {
                return false;
            }
        }

        return true;
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

        // no value, no regex, no fail
        if (true === empty($sFieldValue))
        {
            return true;
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
     * @param string $sUpload
     * @return bool
     */
    protected static function noFilesUploaded(string $sUpload) : bool
    {
        // 4 => 'No file was uploaded'; @see https://www.php.net/manual/de/features.file-upload.errors.php#115746
        return (true === in_array(4, array_filter((($_FILES[$sUpload] ?? array())['error'] ?? array()))));
    }

    /**
     * @param string $sUpload
     * @return bool
     */
    protected static function validUploadExists(string $sUpload) : bool
    {
        // get from Files
        $aFiles = ($_FILES[$sUpload] ?? array());

        // false on any error (value > 0); @see https://www.php.net/manual/de/features.file-upload.errors.php#115746
        if (true === (false === empty(array_filter(($aFiles['error'] ?? array())))))
        {
            return false;
        }

        return true;
    }

    /**
     * validates $_FILES structure and errors
     * @param string $sUpload
     * @param mixed  $none
     * @return bool
     */
	public static function _FILE(string $sUpload, mixed $none) : bool
	{
        // no files, no validation
        if (true === self::noFilesUploaded($sUpload))
        {
            return true;
        }

        // no validate
        if (false === self::validUploadExists($sUpload))
        {
            return false;
        }

        // get the Files
        $aFiles = ($_FILES[$sUpload] ?? array());

        // check syntax of $aFiles - how it compares to common $_FILES array syntax
        if (false === (0 === count(array_diff(array('name', 'full_path', 'type', 'tmp_name', 'error', 'size'), array_keys($aFiles)))))
        {
            return false;
        }

		return true;
	}

    /**
     * validates filetype
     * @param string $sUpload
     * @param array  $aExpect
     * @return bool
     * @throws \ReflectionException
     */
	public static function _FILETYPE(string $sUpload, array $aExpect) : bool
    {
        // no files, no validation
        if (true === self::noFilesUploaded($sUpload))
        {
            return true;
        }

        // no validate
        if (false === self::validUploadExists($sUpload))
        {
            return false;
        }

        // get the Files
        $aFiles = ($_FILES[$sUpload] ?? array());
        $aExpectValue = array_column($aExpect, 'value');

        foreach ($aFiles['type'] as $sType)
        {
            if (false === in_array($sType, $aExpectValue))
            {
                return false;
            }
        }

    	return true;
	}

    /**
     * validates max filesize of file
     * @param string $sUpload
     * @param int    $iMaxfilesize
     * @return bool
     * @throws \ReflectionException
     */
	public static function _FILEMAXFILESIZE(string $sUpload, int $iMaxfilesize) : bool
	{
        // no files, no validation
        if (true === self::noFilesUploaded($sUpload))
        {
            return true;
        }

        // no validate
        if (false === self::validUploadExists($sUpload))
        {
            return false;
        }

        // get the Files
        $aFiles = ($_FILES[$sUpload] ?? array());
        $iSize = array_sum($aFiles['size']);

        // check size
        if  ($iSize > $iMaxfilesize)
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
     * @param string $sPattern
     * @return bool
     */
    public static function _URL(mixed $sFieldValue, string $sPattern) : bool
    {
        if (true === is_array($sFieldValue))
        {
            $sFieldValue = current($sFieldValue);
        }

        if (true === is_string($sFieldValue))
        {
            return (bool) filter_var($sFieldValue, FILTER_VALIDATE_URL);
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
