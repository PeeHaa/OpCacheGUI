<?php
/**
 * Bootstrap the tests. This enables autoloading of mock classes and the library.
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUITest
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUITest;

date_default_timezone_set('Europe/Amsterdam');

session_start();

/**
 * Simple SPL autoloader for the OpCacheGUITest libraries.
 *
 * @param string $class The class name to load
 *
 * @return void
 */
spl_autoload_register(function ($class) {
    $nslen = strlen(__NAMESPACE__);
    if (substr($class, 0, $nslen) != __NAMESPACE__) {
        return;
    }
    $path = substr(str_replace('\\', '/', $class), $nslen);
    $path = __DIR__ . $path . '.php';
    if (file_exists($path)) {
        require $path;
    }
});

/**
 * Load the project's autoloader
 */
require_once __DIR__ . '/../src/OpCacheGUI/bootstrap.php';
