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
use OpCacheGUI\I18n\Translator;

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
    const RED = '#e74c3c';
    const GREEN = '#2ecc71';

    /**
     * @var \OpCacheGUI\Format\Byte Formatter of byte values
     */
    private $byteFormatter;

    /**
     * @var \OpCacheGUI\APCu\Configuration The config of APCu
     */
    private $config;

    /**
     * @var \OpCacheGUI\I18n\Translator A translator
     */
    private $translator;

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
     * @param \OpCacheGUI\I18n\Translator    $translator    A translator
     * @param array                          $cacheStatus   The (unfiltered) output of apcu_cache_info()
     * @param array                          $memoryStatus  The (unfiltered) output of apcu_sma_info()
     */
    public function __construct(
        Byte $byteFormatter,
        Configuration $config,
        Translator $translator,
        array $cacheStatus,
        array $memoryStatus) {
        $this->byteFormatter = $byteFormatter;
        $this->config = $config;
        $this->translator = $translator;
        $this->cacheStatus = $cacheStatus;
        $this->memoryStatus = $memoryStatus;
    }

    /**
     * Gets the status info of OpCache
     *
     * @return array The status info
     */
    public function getStatusInfo()
    {
        $sharedMemory = $this->memoryStatus['num_seg'] . ' segment(s) with ';
        $sharedMemory .= $this->byteFormatter->format($this->memoryStatus['seg_size']) . ' ';
        $sharedMemory .= '(' . $this->cacheStatus['memory_type'] . ' memory' . ')';
        //var_dump($this->cacheStatus);
        return [
            'enabled' => $this->config->getIniDirectives()['apc.enabled'],
            'file_upload_support' => $this->config->getIniDirectives()['apc.rfc1867'],
            'version' => $this->cacheStatus['version'],
            'shared_memory' => $sharedMemory,
            'start_time' => (new \DateTime('@' . $this->cacheStatus['stime']))->format('d-m-Y H:i:s'),
            'uptime' => $this->getTimeAgo(new \DateTime('@' . $this->cacheStatus['stime'])),
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
        $up = clone $datetime;

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
            'total_memory' => $this->byteFormatter->format($size),
            'used_memory' => $this->byteFormatter->format($size - $this->memoryStatus['avail_mem']),
            'free_memory' => $this->byteFormatter->format($this->memoryStatus['avail_mem']),
            'fragmentation_percent' => $this->getFragmentationPercent() . '%',
            'fragmentation_bytes' => $this->byteFormatter->format($this->getFragmentationBytes()),
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
        $freeTotal = 0;

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
        $freeTotal = 0;

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
     * Gets the memory info formatted to build a graph
     *
     * @return string JSON encoded memory info
     */
    public function getGraphMemoryInfo()
    {
        $size = $this->memoryStatus['num_seg'] * $this->memoryStatus['seg_size'];

        return json_encode([
            [
                'value' => $size - $this->memoryStatus['avail_mem'],
                'color' => self::DARK_GREEN,
                'label' => $this->translator->translate('apcu.graph.memory.used'),
            ],
            [
                'value' => $this->memoryStatus['avail_mem'],
                'color' => self::GREEN,
                'label' => $this->translator->translate('apcu.graph.memory.free'),
            ],
        ]);
    }

    /**
     * Gets the statistics info
     *
     * @return array The statistics info
     */
    public function getStatsInfo()
    {
        $cachedSize = $this->byteFormatter->format($this->cacheStatus['mem_size']);
        //echo '<pre>';        print_r($this->cacheStatus);        echo '</pre>';
        return [
            'cached_vars' => $this->cacheStatus['nentries'] . ' (' . $cachedSize . ')',
            'num_hits' => $this->cacheStatus['nhits'],
            'num_misses' => $this->cacheStatus['nmisses'],
            'req_rate_user' => number_format($this->getRequestRate(), 2),
            'hit_rate_user' => number_format($this->getHitRate(), 2),
            'miss_rate_user' => number_format($this->getMissRate(), 2),
            'insert_rate_user' => number_format($this->getInsertRate(), 2),
            'num_expunges' => $this->cacheStatus['nexpunges'],
        ];
    }

    /**
     * Gets the hit info formatted to build a graph
     *
     * @return string JSON encoded memory info
     */
    public function getGraphHitStatsInfo()
    {
        return json_encode([
            [
                'value' => $this->cacheStatus['num_expunges'],
                'color' => self::DARK_GREEN,
                'label' => $this->translator->translate('apcu.graph.hits.expunges'),
            ],
            [
                'value' => $this->cacheStatus['num_hits'],
                'color' => self::GREEN,
                'label' => $this->translator->translate('apcu.graph.hits.hits'),
            ],
            [
                'value' => $this->cacheStatus['num_misses'],
                'color' => self::RED,
                'label' => $this->translator->translate('apcu.graph.hits.misses'),
            ],
        ]);
    }

    /**
     * Gets the request rate
     *
     * @return int|float The request rate
     */
    private function getRequestRate()
    {
        if (!$this->cacheStatus['nhits']) {
            return 0;
        }

        $datetime = new \DateTime();

        $requestRate = $this->cacheStatus['nhits'] + $this->cacheStatus['nmisses'];
        $requestRate /= $datetime->format('U') - $this->cacheStatus['stime'];

        return $requestRate;
    }

    /**
     * Gets the hit rate
     *
     * @return int|float The hit rate
     */
    private function getHitRate()
    {
        if (!$this->cacheStatus['nhits']) {
            return 0;
        }

        $datetime = new \DateTime();

        return $this->cacheStatus['nhits'] / ($datetime->format('U') - $this->cacheStatus['stime']);
    }

    /**
     * Gets the miss rate
     *
     * @return int|float The miss rate
     */
    private function getMissRate()
    {
        if (!$this->cacheStatus['nmisses']) {
            return 0;
        }

        $datetime = new \DateTime();

        return $this->cacheStatus['nmisses'] / ($datetime->format('U') - $this->cacheStatus['stime']);
    }

    /**
     * Gets the insert rate
     *
     * @return int|float The insert rate
     */
    private function getInsertRate()
    {
        if (!$this->cacheStatus['ninserts']) {
            return 0;
        }

        $datetime = new \DateTime();

        return $this->cacheStatus['ninserts'] / ($datetime->format('U') - $this->cacheStatus['stime']);
    }

    /**
     * Gets all cached variables
     *
     * @return array List of all stored variables
     */
    public function getVariables()
    {
        if (!$this->cacheStatus['cache_list']) {
            return [];
        }

        $entries = [];
        /*echo '<pre>';
        print_r($this->cacheStatus['cache_list']);
        echo '</pre>';
        die();*/
        foreach ($this->cacheStatus['cache_list'] as $index => $variable) {

            $entry = $this->cacheStatus['cache_list'][$index];

            $variable['mem_size'] = $this->byteFormatter->format($variable['mem_size']);

            $variable['num_hits'] = $entry['nhits'];
            $variable['info'] = $entry['key'];

            $variable['access_time'] = null;
            if ($entry['atime']) {
                $dateTime = new \DateTime('@' . $entry['atime']);

                $variable['access_time'] = $dateTime->format('H:i:s') . '<br>' . $dateTime->format('d-m-Y');
            }

            $variable['modification_time'] = null;
            if ($entry['mtime']) {
                $dateTime = new \DateTime('@' . $entry['mtime']);

                $variable['modification_time'] = $dateTime->format('H:i:s') . '<br>' . $dateTime->format('d-m-Y');
            }

            $variable['creation_time'] = null;
            if ($entry['ctime']) {
                $dateTime = new \DateTime('@' . $entry['ctime']);
                $variable['creation_time'] = $dateTime->format('H:i:s') . '<br>' . $dateTime->format('d-m-Y');
            }

            $variable['deletion_time'] = null;
            if ($entry['dtime']) {
                $dateTime = new \DateTime('@' . $entry['dtime']);

                $variable['deletion_time'] = $dateTime->format('H:i:s') . '<br>' . $dateTime->format('d-m-Y');
            }

            $entries[] = $variable;
        }

        return $entries;
    }
}
