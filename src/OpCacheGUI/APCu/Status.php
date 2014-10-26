<?php
/**
 * Container for the current status of APCu
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    APCu
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\APCu;

use OpCacheGUI\Format\Byte;

/**
 * Container for the current status of APCu
 *
 * @category   OpCacheGUI
 * @package    APCu
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Status
{
    /**
     * @var string The colors of the graphs
     */
    const DARK_GREEN = '#16a085';
    const RED        = '#e74c3c';
    const GREEN      = '#2ecc71';

    /**
     * @var \OpCacheGUI\Format\Byte Formatter of byte values
     */
    private $byteFormatter;

    /**
     * @var \OpCacheGUI\APCu\Configuration The config of APCu
     */
    private $config;

    /**
     * @var array The (unfiltered) output of apcu_cache_info()
     */
    private $cacheStatus;

    /**
     * @var array The (unfiltered) output of apcu_sma_info()
     */
    private $memoryStatus;

    /**
     * Creates instance
     *
     * @param \OpCacheGUI\Format\Byte        $byteFormatter Formatter of byte values
     * @param \OpCacheGUI\APCu\Configuration $config        The config of APCu
     * @param array                          $cacheStatus   The (unfiltered) output of apcu_cache_info()
     * @param array                          $memoryStatus  The (unfiltered) output of apcu_sma_info()
     */
    public function __construct(Byte $byteFormatter, Configuration $config, array $cacheStatus, array $memoryStatus)
    {
        $this->byteFormatter = $byteFormatter;
        $this->config        = $config;
        $this->cacheStatus   = $cacheStatus;
        $this->memoryStatus  = $memoryStatus;
    }

    /**
     * Gets the status info of OpCache
     *
     * @return array The status info
     */
    public function getStatusInfo()
    {
        return [
            'enabled'             => $this->config->getIniDirectives()['apc.enabled'],
            'file_upload_support' => $this->config->getIniDirectives()['apc.rfc1867'],
            'start_time'          => (new \DateTime('@' . $this->cacheStatus['start_time']))->format('d-m-Y H:i:s'),
            'uptime'              => $this->getTimeAgo(new \DateTime('@' . $this->cacheStatus['start_time'])),
        ];
    }

    /**
     * Gets the human readable "time ago" value between a DateTime object and now
     *
     * @param \DateTime $datetime The datetime to compare against
     *
     * @return string The human readable diff
     */
    private function getTimeAgo(\DateTime $datetime)
    {
        $now = new \DateTime('now', new \DateTimeZone(date_default_timezone_get()));
        $up  = clone $datetime;

        $up->setTimeZone(new \DateTimeZone(date_default_timezone_get()));

        $diff = $now->diff($up);

        $optionalUnits = [
            'y' => [' year ', ' years '],
            'm' => [' month ', ' months '],
            'd' => [' day ', ' days '],
            'h' => [' hour and ', ' hours and '],
        ];

        $timeAgo = '';

        foreach ($optionalUnits as $unit => $values) {
            if ($diff->$unit) {
                $timeAgo .= $diff->$unit;
                $timeAgo .= $diff->$unit > 1 ? $values[1] : $values[0];
            }
        }

        $timeAgo .= $diff->i . ' minute';
        $timeAgo .= $diff->i > 1 ? 's' : '';

        return $timeAgo;
    }

    /**
     * Gets the memory info of APCu
     *
     * @return array The memory info
     */
    public function getMemoryInfo()
    {
        $size = $this->memoryStatus['num_seg'] * $this->memoryStatus['seg_size'];

        return [
            'total_memory'            => $this->byteFormatter->format($size),
            'used_memory'             => $this->byteFormatter->format($size - $this->memoryStatus['avail_mem']),
            'free_memory'             => $this->byteFormatter->format($this->memoryStatus['avail_mem']),
            'fragmentation_percent'   => $this->getFragmentationPercent() . '%',
            'fragmentation_bytes'     => $this->byteFormatter->format($this->getFragmentationBytes()),
            'fragmentation_fragments' => $this->getFragmentationSegments(),
        ];
    }

    /**
     * Calculates the percentage of fragmentation
     *
     * Note that only blocks < 5MB are considered doe the fragmentation
     *
     * @return float The percentage of fragmentation
     */
    private function getFragmentationPercent()
    {
        $fragmentationSize = 0;
        $freeTotal         = 0;

        for ($i = 0; $i < $this->memoryStatus['num_seg']; $i++) {
            foreach ($this->memoryStatus['block_lists'][$i] as $block) {
                if ($block['size'] < (5 * 1024 * 1024)) {
                    $fragmentationSize += $block['size'];
                }

                $freeTotal += $block['size'];
            }
        }

        return number_format(($fragmentationSize / $freeTotal) * 100, 2);
    }

    /**
     * Calculates the number of bytes of fragmentation
     *
     * Note that only blocks < 5MB are considered doe the fragmentation
     *
     * @return int The number of bytes of fragmentation
     */
    private function getFragmentationBytes()
    {
        $fragmentationSize = 0;
        $freeTotal         = 0;

        for ($i = 0; $i < $this->memoryStatus['num_seg']; $i++) {
            foreach ($this->memoryStatus['block_lists'][$i] as $block) {
                if ($block['size'] < (5 * 1024 * 1024)) {
                    $fragmentationSize += $block['size'];
                }

                $freeTotal += $block['size'];
            }
        }

        return $fragmentationSize;
    }

    /**
     * Calculates the number of segments of fragmentation
     *
     * Note that only blocks < 5MB are considered doe the fragmentation
     *
     * @return int The number of fragmentated segments
     */
    private function getFragmentationSegments()
    {
        $fragmentationSegments = 0;

        for ($i = 0; $i < $this->memoryStatus['num_seg']; $i++) {
            $fragmentationSegments += count($this->memoryStatus['block_lists'][$i]);
        }

        return $fragmentationSegments;
    }

    /**
     * Gets the statistics info
     *
     * @return array The statistics info
     */
    public function getStatsInfo()
    {
        return [
            'cached_vars'      => '0 (0 bytes)',
            'num_hits'         => 0,
            'num_misses'       => 0,
            'req_rate_user'    => '0.00',
            'hit_rate_user'    => '0.00',
            'miss_rate_user'   => '0.00',
            'insert_rate_user' => '0.00',
            'num_expunges'     => '0.00',
        ];
    }
}
