<?php
/**
 * Container for the configuration of OpCache
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    OpCache
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\OpCache;

use OpCacheGUI\Format\Byte;

/**
 * Container for the configuration of OpCache
 *
 * @category   OpCacheGUI
 * @package    OpCache
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Configuration
{
    /**
     * @var array The (unfiltered) output of opcache_get_configuration()
     */
    private $configData;

    /**
     * @var \OpCacheGUI\Format\Byte Formatter of byte values
     */
    private $byteFormatter;

    /**
     * Creates instance
     *
     * @param \OpCacheGUI\Format\Byte $byteFormatter Formatter of byte values
     * @param array                   $configData    The configuration data from opcache
     */
    public function __construct(Byte $byteFormatter, array $configData)
    {
        $this->byteFormatter = $byteFormatter;
        $this->configData    = $configData;
    }

    /**
     * Gets the ini directives of OpCache
     *
     * @return array The ini directives
     */
    public function getIniDirectives()
    {
        $directives = $this->configData['directives'];

        $directives['opcache.memory_consumption'] = $this->byteFormatter->format($directives['opcache.memory_consumption']);

        unset($directives['opcache.inherited_hack']);

        return $directives;
    }

    /**
     * Gets blacklisted files
     *
     * @return array List of blacklisted files
     */
    public function getBlackList()
    {
        return $this->configData['blacklist'];
    }
}
