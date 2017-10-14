<?php
/**
 * Example file for setting up the environment specific configuration
 *
 * Note: you probably don't want to use the configuration in your project
 * directly, but instead you want to:
 * 1) copy this file
 * 2) make the changes to the copy for your specific environment
 * 3) load your specific configuration file in the init.deployment.php file
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */

namespace OpCacheGUI;

use OpCacheGUI\Network\Router;

/**
 * Login credentials
 *
 * The password is a password compatible with PHP's password hashing functions (password_hash())
 *
 * Only addresses on the whitelist are allowed to log in
 * The whitelist can contain a list of IP addresses or ranges in one of the following formats:
 *
 * * allows any IP address to log in (effectively disabling the whitelist and allowing access from any IP)
 * localhost or 127.0.0.1 allows only log ins from the machine on which the application runs
 * 10.0.0.5 allows a single address access
 * 10.0.0.* allows any log in from the range starting from 10.0.0.0 to 10.0.0.255. All octets but the first can be a wildcard
 * 10.0.0.1-10.0.0.24 defines a range of IP addresses which are allowed to log in (including the IP addresses defining the range)
 * 10.0.0.10/24 defines a range of IP addresses in the CIDR format
 *
 * Multiple addresses or ranges can be defined
 */
return [
    'username'        => 'peehaa',
    'password'        => '$2y$14$kHoRlbxPF7Bf1903cDMTgeYBsFgF8aJA46LIH9Nsg4/ocDa9HTTbe',
    'whitelist'       => [
        'localhost',
    ],
    'language'        => 'en',
    'timezone'        => 'Europe/Amsterdam',
    'error_reporting' => E_ALL,
    'display_errors'  => 'Off',
    'log_errors'      => 'On',
    'uri_scheme'      => Router::URL_REWRITE
];
