<?php
/**
 * Bootstrap the project
 *
 * PHP version 5.5
 *
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
use OpCacheGUI\Format\Byte as ByteFormatter;
use OpCacheGUI\Storage\Session;
use OpCacheGUI\Auth\Ip;
use OpCacheGUI\Security\Generator\Factory;
use OpCacheGUI\Security\CsrfToken;
use OpCacheGUI\Auth\User;
use OpCacheGUI\Network\Request;
use OpCacheGUI\Presentation\Url;
use OpCacheGUI\Presentation\Html;
use OpCacheGUI\Presentation\Json;
use OpCacheGUI\Network\Router;
use OpCacheGUI\Network\RouteFactory;

/**
 * Bootstrap the library
 */
require_once __DIR__ . '/src/OpCacheGUI/bootstrap.php';

/**
 * Setup the environment
 */
require_once __DIR__ . '/init.deployment.php';

/**
 * Start the session
 */
session_start();

/**
 * Setup formatters
 */
$byteFormatter = new ByteFormatter;

/**
 * Setup CSRF token
 */
$sessionStorage = new Session();
$csrfToken      = new CsrfToken($sessionStorage, new Factory());

/**
 * Setup the IP whitelist
 */
$whitelist = new Ip([
    new \OpCacheGUI\Network\Ip\Any(),
    new \OpCacheGUI\Network\Ip\Localhost(),
    new \OpCacheGUI\Network\Ip\Single(),
    new \OpCacheGUI\Network\Ip\Wildcard(),
    new \OpCacheGUI\Network\Ip\Range(),
    new \OpCacheGUI\Network\Ip\Cidr(),
]);
$whitelist->buildWhitelist($login['whitelist']);

/**
 * Setup the authentication object
 */
$user = new User($sessionStorage, $login['username'], $login['password'], $whitelist);

/**
 * Setup URL renderer
 */
$urlRenderer = new Url($uriScheme);

/**
 * Setup the HTML template renderer
 */
$htmlTemplate = new Html(__DIR__ . '/template', 'page.phtml', $translator, $urlRenderer);

/**
 * Setup the JSON template renderer
 */
$jsonTemplate = new Json(__DIR__ . '/template', $translator);

/**
 * Setup the request object
 */
$request = new Request($_GET, $_POST, $_SERVER);

/**
 * Setup the router
 */
$routeFactory = new RouteFactory();
$router       = new Router($request, $routeFactory, $uriScheme);

/**
 * Load public routes
 */
require_once __DIR__ . '/public-routes.php';

/**
 * Load the routes
 */
if (!extension_loaded('Zend OPcache') || opcache_get_status() === false) {
    if (!in_array($router->getIdentifier(), ['error', 'mainjs', 'maincss', 'fontawesome-webfont_eot', 'fontawesome-webfont_woff', 'fontawesome-webfont_ttf', 'fontawesome-webfont_svg'], true)) {
        header('Location: ' . $urlRenderer->get('error'));
        exit;
    }

    $router->get('error', function() use ($htmlTemplate) {
        return $htmlTemplate->render('error.phtml', [
            'login' => true,
            'title' => 'Error',
            'type'  => !extension_loaded('Zend OPcache') ? 'installed' : 'enabled',
        ]);
    });
} else {
    require_once __DIR__ . '/routes.php';
}

/**
 * Dispatch the request
 */
echo $router->run();
