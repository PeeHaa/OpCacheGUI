<?php
/**
 * Interface for handling IP whitelisting
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Auth
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Auth;

/**
 * Interface for handling IP whitelisting
 *
 * @category   OpCacheGUI
 * @package    Auth
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Whitelist
{
    /**
     * Builds the whitelist
     *
     * @param array $addresses List of addresses which form the whitelist
     *
     * @return void
     */
    public function buildWhitelist(array $addresses);

    /**
     * Checks whether the ip is allowed access
     *
     * @param string $ip The IP address to check
     *
     * @return boolean True when the IP is allowed access
     */
    public function isAllowed($ip);
}
