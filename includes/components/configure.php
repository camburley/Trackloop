<?php

/**
 * Configuration class used to 
 * or just an individual value
 */
class Configure
{
	protected $params = array();
	protected $environment = array();
	protected static $instances = array();

/**
 * Class constructor
 *
 * @param string $filename Relative or full filename to the configuration file
 */
	protected function __construct($filename)
	{
		// load and parse configuration file
		$config = parse_ini_file($filename, true);
		$this->params = $config;
		
		// set environment
		$environment = $config['environment'];
		if (empty($config[$environment])) {
			trigger_error('Unknown configuration environment selected', E_USER_ERROR);
		}
		$this->environment = $environment;
	}

/**
 * Singleton function
 * Used to return a single object during the runtime per configuration file.
 *
 * @param string $filename Relative or full filename to the configuration file
 */
	public static function instance($filename)
	{
		if (!isset(self::$instances[$filename])) {
			self::$instances[$filename] = new Configure($filename);
		}
		
		return self::$instances[$filename];
	}

/**
 * Add/overwrite a configuarion item to the currently loaded params
 *
 * @param string $param Configuration key
 * @param mixed  $value Configuration value
 */
	public function write($param, $value)
	{
		$this->params[$this->environment][$param] = $value;
	}
	
/**
 * Used to read the whole array of loaded configuration parameters
 * or just an individual value
 *
 * @param string $param Configuration key whose value is to be returned
 * @return mixed Configuration value, or null.
 */
	public function read($param = null)
	{
		if (null === $param) {
			return $this->params[$this->environment];
		}
		
		return !empty($this->params[$this->environment][$param])
			? $this->params[$this->environment][$param]
			: null;
	}
}