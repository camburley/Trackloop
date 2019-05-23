<?php

error_reporting(E_ALL ^ E_NOTICE);
ini_set("display_errors", 1);

require 'bootstrap.php';

class Application
{	
	protected static $params = array();
	protected static $requestData = array();

/** 
 * Class constructor
*/	
	public function __construct()
	{
		self::$requestData = array_merge($_GET, $_POST);
	}
	
/** 
 * Prepare the application for running and try to dispatch the required action
 *
 * @return void
*/
	public function run()
	{
		$router = Registry::get('router');
		$route = $router->match();
		
		if (!$route) {
			$this->_blackhole(404, 'Not Found');
		}

		if($route['target'] == 'home') {
			self::redirect('/stage/artist/index.php');
			return;
		}
				
		self::$params = $route['params'];
		$this->dispatch($route);
	}
	
/** 
 * Request dispatcher
 *
 * @param string $route Request route
*/
	public function dispatch($route)
	{
		list($action, $controller) = explode('@', $route['target']);
		$controllerPath = TL_PATH . 'actions' . DS . $controller . DS . $action . '.php';
		
		if (!file_exists($controllerPath)) {
			trigger_error("Couldn't load $controllerName", E_USER_ERROR);
		}
		
		$view = Registry::get('view');
		$apicaller = Registry::get('apicaller');
		
		// run controller
		require $controllerPath;
	}
	
	public static function render($template, $layout = null)
	{
		$view = Registry::get('view');
		$view->assign('base', Registry::get('config')->read('app.url'));
		// process any flash messages
		self::flashMessage();
		
		// process the template
		$template .= '.tpl';
		if (!empty($layout)) {
			$template = 'extends:layouts/' . $layout . '.tpl|' . $template;
		}
		$response = $view->fetch($template);
		
		// send response to the browser
		echo $response; exit;
	}
	
	public static function allow($roles, $sectionid = null)
	{
		if (empty($_SESSION['role'])) {
			self::redirect('/login');
		}
		
		$currentRole = $_SESSION['role'];
		$allowedRoles = explode(',', str_replace(' ', '', $roles));
		
		// make sure only allowed roles can access the requested route
		if (!in_array($currentRole, $allowedRoles)) {
			self::setFlash("You don't have enough permissions.", 'error');
			self::redirect('/artist');
			return false;
		}
		
		// make sure only the allowed sections are accessible by the "member" role
		if ('member' == $currentRole && null !== $sectionid && !in_array($sectionid, $_SESSION['sectionid'])) {
			self::setFlash("You don't have enough permissions.", 'error');
			self::redirect('/artist');
			return false;
		}
		
		return true;
	}
	
	public static function setFlash($message, $messageType = 'success')
	{
		$_SESSION['flash'] = array(
			'message' => $message,
			'messageType' => $messageType
		);
	}
	
	public static function flashMessage()
	{
		// set view vars
		if (!empty($_SESSION['flash'])) {
			$view = Registry::get('view');			
			$view->assign('message', $_SESSION['flash']['message']);
			$view->assign('messageType', $_SESSION['flash']['messageType']);
		}
		
		// remove message from session
		$_SESSION['flash'] = array();
	}
	
	public static function redirect($uri)
	{
		$base = trim(Registry::get('config')->read('app.url'), '/');
		header("Location: {$base}{$uri}");
		exit;
	}
	
	public static function param($name)
	{
		return !empty(self::$params[$name])
			? self::$params[$name]
			: null;
	}
	
	public function data($name = null)
	{
		if (empty($name)) {
			return self::$requestData;
		}
		
		return !empty(self::$requestData[$name])
			? self::$requestData[$name]
			: null;
	}
	
	public function _blackhole($code, $status) {		
		$view = Registry::get('view');
		$view->assign('message', "$code $status");
		
		header('HTTP/1.0 ' . $code . ' ' . $status);
		$this->render('error');
	}
}

$application = new Application();
$application->run();