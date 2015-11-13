<?php 

$GLOBALS['_APPREQUEST'] = array();

require_once 'filterinput.php';

class Request
{
	function Request()
	{
	}
	
	public static function getMethod()
	{
		$method = strtoupper($_SERVER['REQUEST_METHOD']);
		return $method;
	}	
	
	public static function getVar($name, $default = null, $hash = 'default', $type = 'none', $mask = 0)
	{
            
		// Ensure hash and type are uppercase
		$hash = strtoupper($hash);
		if ($hash === 'METHOD')
		{
			$hash = strtoupper($_SERVER['REQUEST_METHOD']);
		}

		$type = strtoupper($type);
		$sig = $hash . $type . $mask;

		// Get the input hash
		switch ($hash)
		{
			case 'GET':
				$input = &$_GET;
				break;
			case 'POST':
				$input = &$_POST;
				break;
			case 'FILES':
				$input = &$_FILES;
				break;
			case 'COOKIE':
				$input = &$_COOKIE;
				break;
			case 'ENV':
				$input = &$_ENV;
				break;
			case 'SERVER':
				$input = &$_SERVER;
				break;
			default:
				$input = &$_REQUEST;
				$hash = 'REQUEST';
				break;
		}

		if (isset($GLOBALS['_APPREQUEST'][$name]['SET.' . $hash]) && ($GLOBALS['_APPREQUEST'][$name]['SET.' . $hash] === true))
		{
			// Get the variable from the input hash
			$var = (isset($input[$name]) && $input[$name] !== null) ? $input[$name] : $default;
			$var = self::_cleanVar($var, $mask, $type);
		}
		elseif (!isset($GLOBALS['_APPREQUEST'][$name][$sig]))
		{
			if (isset($input[$name]) && $input[$name] !== null)
			{
                          
				// Get the variable from the input hash and clean it
				$var = self::_cleanVar($input[$name], $mask, $type);
  
				// Handle magic quotes compatibility
				if (get_magic_quotes_gpc() && ($var != $default) && ($hash != 'FILES'))
				{
					$var = self::_stripSlashesRecursive($var);
				}

				$GLOBALS['_APPREQUEST'][$name][$sig] = $var;
			}
			elseif ($default !== null)
			{                            
				// Clean the default value
				$var = self::_cleanVar($default, $mask, $type);
			}
			else
			{
				$var = $default;
			}
		} else {                    
			$var = $GLOBALS['_APPREQUEST'][$name][$sig];
		}
               
		return $var;
	}

	static function getInt($name, $default = null, $hash = 'default')
	{	
		return self::getVar($name, $default, $hash, 'int');
	}
	
	public static function getUInt($name, $default = 0, $hash = 'default')
	{
		return self::getVar($name, $default, $hash, 'uint');
	}
		
	public static function getFloat($name, $default = 0.0, $hash = 'default')
	{
		return self::getVar($name, $default, $hash, 'float');
	}
	
	
	public static function getBool($name, $default = false, $hash = 'default')
	{
		return self::getVar($name, $default, $hash, 'bool');
	}

	public static function getWord($name, $default = '', $hash = 'default')
	{
		return self::getVar($name, $default, $hash, 'word');
	}
	
	public static function getCmd($name, $default = '', $hash = 'default')
	{
		return self::getVar($name, $default, $hash, 'cmd');
	}
	
	public static function getString($name, $default = '', $hash = 'default', $mask = 0)
	{
		// Cast to string, in case JREQUEST_ALLOWRAW was specified for mask
		return (string) self::getVar($name, $default, $hash, 'string', $mask);
	}
	
	
	public static function setVar($name, $value = null, $hash = 'method', $overwrite = true)
	{
		// If overwrite is true, makes sure the variable hasn't been set yet
		if (!$overwrite && array_key_exists($name, $_REQUEST))
		{
			return $_REQUEST[$name];
		}

		// Clean global request var
		$GLOBALS['_APPREQUEST'][$name] = array();

		// Get the request hash value
		$hash = strtoupper($hash);
		if ($hash === 'METHOD')
		{
			$hash = strtoupper($_SERVER['REQUEST_METHOD']);
		}

		$previous = array_key_exists($name, $_REQUEST) ? $_REQUEST[$name] : null;

		switch ($hash)
		{
			case 'GET':
				$_GET[$name] = $value;
				$_REQUEST[$name] = $value;
				break;
			case 'POST':
				$_POST[$name] = $value;
				$_REQUEST[$name] = $value;
				break;
			case 'COOKIE':
				$_COOKIE[$name] = $value;
				$_REQUEST[$name] = $value;
				break;
			case 'FILES':
				$_FILES[$name] = $value;
				break;
			case 'ENV':
				$_ENV['name'] = $value;
				break;
			case 'SERVER':
				$_SERVER['name'] = $value;
				break;
		}

		// Mark this variable as 'SET'
		$GLOBALS['_APPREQUEST'][$name]['SET.' . $hash] = true;
		$GLOBALS['_APPREQUEST'][$name]['SET.REQUEST'] = true;

		return $previous;
	}
	
	
	public static function get($hash = 'default', $mask = 0)
	{
		$hash = strtoupper($hash);

		if ($hash === 'METHOD')
		{
			$hash = strtoupper($_SERVER['REQUEST_METHOD']);
		}

		switch ($hash)
		{
			case 'GET':
				$input = $_GET;
				break;

			case 'POST':
				$input = $_POST;
				break;

			case 'FILES':
				$input = $_FILES;
				break;

			case 'COOKIE':
				$input = $_COOKIE;
				break;

			case 'ENV':
				$input = &$_ENV;
				break;

			case 'SERVER':
				$input = &$_SERVER;
				break;

			default:
				$input = $_REQUEST;
				break;
		}

		$result = self::_cleanVar($input, $mask);

		// Handle magic quotes compatibility
		if (get_magic_quotes_gpc() && ($hash != 'FILES'))
		{
			$result = self::_stripSlashesRecursive($result);
		}

		return $result;
	}
	
	public static function set($array, $hash = 'default', $overwrite = true)
	{
		foreach ($array as $key => $value)
		{
			self::setVar($key, $value, $hash, $overwrite);
		}
	}
	
	static function _cleanVar($var, $mask = 0, $type = null)
	{
		// If the no trim flag is not set, trim the variable
		if (!($mask & 1) && is_string($var))
		{
			$var = trim($var);
		}

		// Now we handle input filtering
		if ($mask & 2)
		{
			// If the allow raw flag is set, do not modify the variable
			$var = $var;
		}
		elseif ($mask & 4)
		{
			// If the allow HTML flag is set, apply a safe HTML filter to the variable
			$safeHtmlFilter = APPFilterInput::getInstance(null, null, 1, 1);
			$var = $safeHtmlFilter->clean($var, $type);
		}
		else
		{
			// Since no allow flags were set, we will apply the most strict filter to the variable
			// $tags, $attr, $tag_method, $attr_method, $xss_auto use defaults.
			$noHtmlFilter = APPFilterInput::getInstance();
			$var = $noHtmlFilter->clean($var, $type);
		}
		return $var;
	}
	
	protected static function _stripSlashesRecursive($value)
	{
		$value = is_array($value) ? array_map(array('Request', '_stripSlashesRecursive'), $value) : stripslashes($value);
		return $value;
	}
	
}



?>