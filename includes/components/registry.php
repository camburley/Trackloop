<?php

class Registry
{
	protected static $objects = array();
	
	protected function __construct()
	{
	}
	
	public static function get($name)
	{
		if (!isset(self::$objects[$name])) {
			return null;
		}
		
		return self::$objects[$name];
	}
	
	public static function set($name, $object)
	{
		self::$objects[$name] = $object;
	}
}