<?php
/**
 * Container for the current status of OpCache
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
 * Container for the current status of OpCache
 *
 * @category   OpCacheGUI
 * @package    OpCache
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Status
{
    /**
     * @var array The (unfiltered) output of `opcache_get_status()`
     */
    private $statusData;

    /**
     * @var \OpCacheGUI\Format\Byte Formatter of byte values
     */
    private $byteFormatter;

    /**
     * Creates instance
     *
     * @param \OpCacheGUI\Format\Byte $byteFormatter Formatter of byte values
     */
    public function __construct(Byte $byteFormatter)
    {
        $this->byteFormatter = $byteFormatter;
        $this->statusData    = opcache_get_status();
    }

    /**
     * Gets the status info of OpCache
     *
     * @return array The status info
     */
    public function getStatusInfo()
    {
        return [
            'opcache_enabled'     => $this->statusData['opcache_enabled'],
            'cache_full'          => $this->statusData['cache_full'],
            'restart_pending'     => $this->statusData['restart_pending'],
            'restart_in_progress' => $this->statusData['restart_in_progress'],
        ];
    }

    /**
     * Gets the memory info of OpCache
     *
     * @return array The memory info
     */
    public function getMemoryInfo()
    {
        return [
            'used_memory'               => $this->byteFormatter->format($this->statusData['memory_usage']['used_memory']),
            'free_memory'               => $this->byteFormatter->format($this->statusData['memory_usage']['free_memory']),
            'wasted_memory'             => $this->byteFormatter->format($this->statusData['memory_usage']['wasted_memory']),
            'current_wasted_percentage' => round($this->statusData['memory_usage']['current_wasted_percentage'], 2) . '%',
        ];
    }
}
