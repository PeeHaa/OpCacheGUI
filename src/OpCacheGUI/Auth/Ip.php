<?php
/**
 * Handles IP whitelisting
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
 * Handles IP whitelisting
 *
 * @category   OpCacheGUI
 * @package    Auth
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Ip implements Whitelist
{
    /**
     * @var \OpCacheGUI\Network\Ip\Converter[] List of address to range converters
     */
    private $converters = [];

    /**
     * @var array List of whitelist ranges
     */
    private $whitelists = [];

    /**
     * Creates instance
     *
     * @param \OpCacheGUI\Network\Ip\Converter[] $converters List of address to range converters
     */
    public function __construct(array $converters)
    {
        $this->converters = $converters;
    }

    /**
     * Builds the whitelist
     *
     * @param array $addresses List of addresses which form the whitelist
     */
    public function buildWhitelist(array $addresses)
    {
        foreach ($addresses as $address) {
            $this->addWhitelist($address);
        }
    }

    /**
     * Adds a range to the whitelist
     *
     * @param string $address The address(range) to add to the whitelist
     */
    private function addWhitelist($address)
    {
        foreach ($this->converters as $converter) {
            if (!$converter->isValid($address)) {
                continue;
            }

            $this->whitelists[] = $converter->convert($address);
        }
    }

    /**
     * Checks whether the ip is allowed access
     *
     * @param string $ip The IP address to check
     *
     * @return boolean True when the IP is allowed access
     */
    public function isAllowed($ip)
    {
        $ip = (float) sprintf('%u', ip2long($ip));

        foreach ($this->whitelists as $whitelist) {
            if ($ip >= $whitelist[0] && $ip <= $whitelist[1]) {
                return true;
            }
        }

        return false;
    }
}
