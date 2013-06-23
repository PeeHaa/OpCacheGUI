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
    OpCacheGUI\Format\Byte as ByteFormatter;

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
 * Setup timezone
 */
ini_set('date.timezone', 'Europe/Amsterdam');

/**
 * Setup the translator
 */
$translator = new Translator('en');

/**
 * Setup formatters
 */
$byteFormatter = new ByteFormatter;

/**
 * Setup routing
 */
switch(trim('/', $_SERVER['REQUEST_URI'])) {
    case 'configuration':
        //
        break;

    default:
        ob_start();
        require __DIR__ . '/template/status.phtml';
        $content = ob_get_contents();
        ob_end_clean();
        break;
}

require __DIR__ . '/template/page.phtml';
