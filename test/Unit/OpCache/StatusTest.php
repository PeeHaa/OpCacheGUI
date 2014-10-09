<?php

namespace OpCacheGUITest\OpCache;

use OpCacheGUI\OpCache\Status;

class StatusTest extends \PHPUnit_Framework_TestCase
{
    protected $statusData;

    protected function setUp()
    {
        $this->statusData = [
            'opcache_enabled'     => true,
            'cache_full'          => false,
            'restart_pending'     => false,
            'restart_in_progress' => false,
            'memory_usage'        => [
                'used_memory'               => '457392',
                'free_memory'               => '133573736',
                'wasted_memory'             => '186600',
                'current_wasted_percentage' => '0.1390278339386',
            ],
            'opcache_statistics'  => [
                'num_cached_scripts'   => 38,
                'num_cached_keys'      => 52,
                'max_cached_keys'      => 7963,
                'hits'                 => 1160,
                'misses'               => 59,
                'blacklist_misses'     => 0,
                'blacklist_miss_ratio' => 0,
                'opcache_hit_rate'     => 95.159967186218,
                'start_time'           => 1412775693,
                'last_restart_time'    => 1412790000,
                'oom_restarts'         => 0,
                'hash_restarts'        => 0,
                'manual_restarts'      => 0,
            ],
            'scripts'             => [
            ],
        ];
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getStatusInfo
     */
    public function testGetStatusInfo()
    {
        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $this->statusData);

        $data = [];

        foreach ($this->statusData as $key => $value) {
            if (!in_array($key, ['opcache_enabled', 'cache_full', 'restart_pending', 'restart_in_progress'], true)) {
                continue;
            }

            $data[$key] = $value;
        }

        $this->assertSame($data, $status->getStatusInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getMemoryInfo
     */
    public function testGetMemoryInfo()
    {
        $formatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');
        $formatter->method('format')->will($this->onConsecutiveCalls('1KB', '2KB', '3KB'));

        $status = new Status($formatter, $this->statusData);

        $data = $this->statusData;

        $data['memory_usage']['used_memory']   = '1KB';
        $data['memory_usage']['free_memory']   = '2KB';
        $data['memory_usage']['wasted_memory'] = '3KB';
        $data['memory_usage']['current_wasted_percentage'] = '0.14%';

        $this->assertSame($data['memory_usage'], $status->getMemoryInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getGraphMemoryInfo
     */
    public function testGetGraphMemoryInfo()
    {
        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $this->statusData);

        $data = [
            [
                'value' => $this->statusData['memory_usage']['wasted_memory'],
                'color' => '#e0642e',
            ],
            [
                'value' => $this->statusData['memory_usage']['used_memory'],
                'color' => '#2e97e0',
            ],
            [
                'value' => $this->statusData['memory_usage']['free_memory'],
                'color' => '#bce02e',
            ],
        ];

        $this->assertSame(json_encode($data), $status->getGraphMemoryInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getStatsInfo
     */
    public function testGetStatsInfoWithOpCacheDisabled()
    {
        $statusData = $this->statusData;
        $statusData['opcache_enabled'] = false;

        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $statusData);

        $data = [
            'num_cached_scripts'   => 0,
            'num_cached_keys'      => 0,
            'max_cached_keys'      => 0,
            'hits'                 => 0,
            'misses'               => 0,
            'blacklist_misses'     => 0,
            'blacklist_miss_ratio' => 'n/a',
            'opcache_hit_rate'     => 'n/a',
            'start_time'           => 'n/a',
            'last_restart_time'    => 'n/a',
            'oom_restarts'         => 'n/a',
            'hash_restarts'        => 'n/a',
            'manual_restarts'      => 'n/a',
        ];

        $this->assertSame($data, $status->getStatsInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getStatsInfo
     */
    public function testGetStatsInfoWithOpCacheEnabled()
    {
        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $this->statusData);

        $data = $this->statusData['opcache_statistics'];

        $data['blacklist_miss_ratio'] = 0.0;
        $data['opcache_hit_rate']     = '95.16%';
        $data['start_time']           = '13:41:33 08-10-2014';
        $data['last_restart_time']    = '17:40:00 08-10-2014';

        $this->assertSame($data, $status->getStatsInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getStatsInfo
     */
    public function testGetStatsInfoWithOpCacheEnabledWithoutRestart()
    {
        $statusData = $this->statusData;

        $statusData['opcache_statistics']['last_restart_time'] = 0;

        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $statusData);

        $data = $this->statusData['opcache_statistics'];

        $data['blacklist_miss_ratio'] = 0.0;
        $data['opcache_hit_rate']     = '95.16%';
        $data['start_time']           = '13:41:33 08-10-2014';
        $data['last_restart_time']    = null;

        $this->assertSame($data, $status->getStatsInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getGraphKeyStatsInfo
     */
    public function testGetGraphKeyStatsInfo()
    {
        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $this->statusData);

        $data = [
            [
                'value' => 14,
                'color' => '#e0642e',
            ],
            [
                'value' => 38,
                'color' => '#2e97e0',
            ],
            [
                'value' => 7911,
                'color' => '#bce02e',
            ],
        ];

        $this->assertSame(json_encode($data), $status->getGraphKeyStatsInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getGraphHitStatsInfo
     */
    public function testGetGraphHitStatsInfo()
    {
        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $this->statusData);

        $data = [
            [
                'value' => 59,
                'color' => '#e0642e',
            ],
            [
                'value' => 0,
                'color' => '#2e97e0',
            ],
            [
                'value' => 1160,
                'color' => '#bce02e',
            ],
        ];

        $this->assertSame(json_encode($data), $status->getGraphHitStatsInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getCachedScripts
     */
    public function testGetCachedScriptsEmpty()
    {
        $statusData = $this->statusData;

        unset($statusData['scripts']);

        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $statusData);

        $this->assertSame([], $status->getCachedScripts());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getCachedScripts
     */
    public function testGetCachedScriptsFilled()
    {
        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $this->statusData);

        $this->markTestIncomplete('Couldn\'t be arsed to test it yet.');
    }
}
