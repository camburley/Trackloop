<?php
session_start();

// application-wide constants
define('DS', DIRECTORY_SEPARATOR);
define('TL_PATH', __DIR__ . DS);
define('TL_INCLUDE_PATH', TL_PATH . 'includes' . DS);

// sections
define('SECTION_RELEASES',    1);
define('SECTION_BUZZ',        2);
define('SECTION_FANS',        3);
define('SECTION_ACCOUNT',     4);
define('SECTION_PERMISSIONS', 5);

// general includes
require TL_INCLUDE_PATH . 'components/utils.php';
require TL_INCLUDE_PATH . 'components/registry.php';
require TL_INCLUDE_PATH . 'components/configure.php';
require TL_INCLUDE_PATH . 'components/apicaller.php';
require TL_INCLUDE_PATH . 'libs/Smarty/Smarty.class.php';
require TL_INCLUDE_PATH . 'libs/AltoRouter.php';

// load dependencies
$config = Configure::instance(TL_INCLUDE_PATH . DS . 'config.ini');
Registry::set('config', $config);

$router = new AltoRouter();
$router->setBasePath('');

Registry::set('router', $router);

$smarty = new Smarty();
$smarty->setTemplateDir(TL_PATH . 'templates');
Registry::set('view', $smarty);

// load api connection
$appID  = $config->read('api.app_id');
$appKey = $config->read('api.app_key');
$apiURL  = $config->read('api.api_url');
$apicaller = new ApiCaller($appID, $appKey, $apiURL);
Registry::set('apicaller', $apicaller);

// Routes
$router->map('GET',      '/', 'home');
$router->map('GET',      '/login-user', 'login@artist');
$router->map('GET|POST', '/login', 'login@artist');
$router->map('GET|POST', '/logout', 'logout@artist');
$router->map('GET',      '/artist', 'welcome@artist');
$router->map('GET|POST', '/artist/account', 'account@artist');
$router->map('GET',      '/artist/buzz', 'buzz@artist');
$router->map('GET',      '/artist/releases', 'releases@artist');
$router->map('GET|POST', '/artist/upload', 'upload@artist');
$router->map('GET|POST', '/artist/uploadcover', 'uploadcover@artist');
$router->map('GET|POST', '/artist/edit/[a:id]', 'upload@artist');
$router->map('GET|POST', '/artist/permissions', 'permissions@artist');
$router->map('GET|POST', '/artist/album/[a:artist]/[a:album]', 'album@artist');

$router->map('GET',      '/fan/connect/[a:artist]/[a:album]', 'connect@fan');
$router->map('GET|POST', '/fan/unlock/[a:artist]/[a:album]', 'unlock@fan');
$router->map('GET|POST', '/fan/download/[a:artist]/[a:album]', 'download@fan');

$router->map('GET|POST', '/forgot-password', 'forgotPassword@artist');

$router->map('GET|POST', '/verify-twitter-account', 'verifyTwitterAccount@artist');
$router->map('GET|POST', '/verify-facebook-account', 'verifyFacebookAccount@artist');
