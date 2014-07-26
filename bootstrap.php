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
use OpCacheGUI\I18n\Translator,
    OpCacheGUI\Format\Byte as ByteFormatter,
    OpCacheGUI\Security\CsrfToken;

/**
 * Bootstrap the library
 */
require_once __DIR__ . '/src/OpCacheGUI/bootstrap.php';

/**
 * Setup error reporting
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 0);

/**
 * Start the session
 */
session_start();

/**
 * Setup timezone
 */
ini_set('date.timezone', 'Europe/Amsterdam');
define('ADMIN_USERNAME','admin'); // <<-- change it
define('ADMIN_PASSWORD','admin1'); // <<-- change it


if (!isset($_SERVER['PHP_AUTH_USER']) ||
      !isset($_SERVER['PHP_AUTH_PW']) ||
      $_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME ||
      $_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD) {
      Header("WWW-Authenticate: Basic realm=\"Opcache Login\"");
      Header("HTTP/1.0 401 Unauthorized");
      echo <<<EOB
        <html><body>
        <h1>Rejected!</h1>
        <big>Wrong Username or Password!</big><br/>&nbsp;<br/>&nbsp;
        </body></html>
EOB;
      exit;
    }




/**
 * Setup the translator
 */
$translator = new Translator('en');

/**
 * Setup formatters
 */
$byteFormatter = new ByteFormatter;

/**
 * Setup CSRF token
 */
$csrfToken = new CsrfToken;

/**
 * Setup routing
 */

$request = explode('/', $_SERVER['REQUEST_URI']);
switch(end($request)) {
    case 'configuration':
        ob_start();
        require __DIR__ . '/template/configuration.phtml';
        $content = ob_get_contents();
        $active = 'config';
        ob_end_clean();
        break;

    case 'cached-scripts':
        ob_start();
        require __DIR__ . '/template/cached.phtml';
        $content = ob_get_contents();
        $active = 'cached';
        ob_end_clean();
        break;

    case 'graphs':
        ob_start();
        require __DIR__ . '/template/graphs.phtml';
        $content = ob_get_contents();
        $active = 'graphs';
        ob_end_clean();
        break;

    case 'reset':
        ob_start();
        require __DIR__ . '/template/reset.pjson';
        return;

    case 'invalidate':
        ob_start();
        require __DIR__ . '/template/invalidate.pjson';
        return;

    default:
        ob_start();
        require __DIR__ . '/template/status.phtml';
        $content = ob_get_contents();
        $active = 'status';
        ob_end_clean();
        break;
}

require __DIR__ . '/template/page.phtml';
