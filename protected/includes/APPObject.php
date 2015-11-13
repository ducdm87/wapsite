<?php


class APPObject
{

	/**
	 * An array of errors
	 *
	 * @var		array of error messages or JExceptions objects
	 * @access	protected
	 * @since	1.0
	 */
	var	$_errors		= array();

	var $_taskMap 	= null;
	
	var $_task 	= null;
	
	var $_doTask 	= null;
	
	var $_methods 	= array();
	
	/**
	 * A hack to support __construct() on PHP 4
	 *
	 * Hint: descendant classes have no PHP4 class_name() constructors,
	 * so this constructor gets called first and calls the top-layer __construct()
	 * which (if present) should call parent::__construct()
	 *
	 * @access	public
	 * @return	Object
	 * @since	1.5
	 */
	function APPObject()
	{
		$args = func_get_args();
		call_user_func_array(array(&$this, '__construct'), $args);
	}

	/**
	 * Class constructor, overridden in descendant classes.
	 *
	 * @access	protected
	 * @since	1.5
	 */
	function __construct() {}


	/**
	 * Returns a property of the object or the default value if the property is not set.
	 *
	 * @access	public
	 * @param	string $property The name of the property
	 * @param	mixed  $default The default value
	 * @return	mixed The value of the property
	 * @see		getProperties()
	 * @since	1.5
 	 */
	function get($property, $default=null)
	{
		if(isset($this->$property)) {
			return $this->$property;
		}
		return $default;
	}

	/**
	 * Returns an associative array of object properties
	 *
	 * @access	public
	 * @param	boolean $public If true, returns only the public properties
	 * @return	array
	 * @see		get()
	 * @since	1.5
 	 */
	function getProperties( $public = true )
	{
		$vars  = get_object_vars($this);

        if($public)
		{
			foreach ($vars as $key => $value)
			{
				if ('_' == substr($key, 0, 1)) {
					unset($vars[$key]);
				}
			}
		}

        return $vars;
	}

	/**
	 * Get the most recent error message
	 *
	 * @param	integer	$i Option error index
	 * @param	boolean	$toString Indicates if JError objects should return their error message
	 * @return	string	Error message
	 * @access	public
	 * @since	1.5
	 */
	function getError($i = null, $toString = true )
	{
		// Find the error
		if ( $i === null) {
			// Default, return the last message
			$error = end($this->_errors);
		}
		else
		if ( ! array_key_exists($i, $this->_errors) ) {
			// If $i has been specified but does not exist, return false
			return false;
		}
		else {
			$error	= $this->_errors[$i];
		}

		// Check if only the string is requested
		if ( JError::isError($error) && $toString ) {
			return $error->toString();
		}

		return $error;
	}

	/**
	 * Return all errors, if any
	 *
	 * @access	public
	 * @return	array	Array of error messages or JErrors
	 * @since	1.5
	 */
	function getErrors()
	{
		return $this->_errors;
	}


	/**
	 * Modifies a property of the object, creating it if it does not already exist.
	 *
	 * @access	public
	 * @param	string $property The name of the property
	 * @param	mixed  $value The value of the property to set
	 * @return	mixed Previous value of the property
	 * @see		setProperties()
	 * @since	1.5
	 */
	function set( $property, $value = null )
	{
		$previous = isset($this->$property) ? $this->$property : null;
		$this->$property = $value;
		return $previous;
	}

	/**
	* Set the object properties based on a named array/hash
	*
	* @access	protected
	* @param	$array  mixed Either and associative array or another object
	* @return	boolean
	* @see		set()
	* @since	1.5
	*/
	function setProperties( $properties )
	{
		$properties = (array) $properties; //cast to an array

		if (is_array($properties))
		{
			foreach ($properties as $k => $v) {
				$this->$k = $v;
			}

			return true;
		}

		return false;
	}

	/**
	 * Add an error message
	 *
	 * @param	string $error Error message
	 * @access	public
	 * @since	1.0
	 */
	function setError($error)
	{
		array_push($this->_errors, $error);
	}

	/**
	 * Object-to-string conversion.
	 * Each class can override it as necessary.
	 *
	 * @access	public
	 * @return	string This name of this class
	 * @since	1.5
 	 */
	function toString()
	{
		return get_class($this);
	}

	/**
	 * Legacy Method, use {@link JObject::getProperties()}  instead
	 *
	 * @deprecated as of 1.5
	 * @since 1.0
	 */
	function getPublicProperties()
	{
		return $this->getProperties();
	}
	
	function loadObject($obj = null)
	{
		/*
		 * We want to leave groups that are already in the namespace and add the
		 * groups loaded into the namespace.  This overwrites any existing group
		 * with the same name
		 */
		
		foreach (get_object_vars($obj) as $k => $v) {
			if (substr($k, 0,1) != '_' || $k == '_name') {
				$this->$k = $v;
			}
		}	

		return true;
	}
	
	function registerTask(){
		if ( in_array( strtolower( $method ), $this->_methods ) ) {
				$this->_taskMap[strtolower( $task )] = $method;
			}
	}
	function execute( $task )
		{
			$this->_task = $task;

			$doTask = $task = strtolower( $task );
			if (isset( $this->_taskMap[$task] )) {
				$doTask = $this->_taskMap[$task];
			} elseif (isset( $this->_taskMap['__default'] )) {
				$doTask = $this->_taskMap['__default'];
			} else if(!method_exists($this,$task)){				
				return die('Task ['.$task.'] not found');
			}
			// Record the actual task being fired
			$this->_doTask = $doTask;
	
			// Make sure we have access
			//if ($this->authorize( $doTask ))
			//{
				$retval = $this->$doTask();
				return $retval;
			//}
		}
	
	function getValue($name, $default=null)
	{
		$result = $default;			
		if(isset($this->$name)) {
			$result = $this->$name;
		}
		return $result;
	}

	function setValue($name, $value)
	{
		// Get the old value if exists so we can return it
		$this->$name =& $value;

		return $this->$name;
	}
	
	function bind( $from, $ignore=array() )
	{
		$fromArray	= is_array( $from );
		$fromObject	= is_object( $from );

		if (!$fromArray && !$fromObject)
		{
			$this->setError( get_class( $this ).'::bind failed. Invalid from argument' );
			return false;
		}
		if (!is_array( $ignore )) {
			$ignore = explode( ' ', $ignore );
		}
		foreach ($this->getProperties() as $k => $v)
		{
			// internal attributes of an object are ignored
			if (!in_array( $k, $ignore ))
			{
				if ($fromArray && isset( $from[$k] )) {
					$this->$k = $from[$k];
				} else if ($fromObject && isset( $from->$k )) {
					$this->$k = $from->$k;
				}
			}
		}
		return true;
	}
}
