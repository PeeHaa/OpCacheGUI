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
                [
                    'full_path'           => '/var/www/vhosts/OpcacheGUI/src/OpCacheGUI/Network/Request.php',
                    'hits'                => 1,
                    'memory_consumption'  => 6608,
                    'last_used'           => 'Thu Oct 09 16:08:35 2014',
                    'last_used_timestamp' => 1412863715,
                    'timestamp'           => 1412698853,
                ],
                [
                    'full_path'           => '/var/www/vhosts/OpcacheGUI/template/cached.phtml',
                    'hits'                => 4,
                    'memory_consumption'  => 3213,
                    'last_used'           => 'Thu Oct 09 16:06:35 2014',
                    'last_used_timestamp' => 1412863715,
                    'timestamp'           => 1412698853,
                ],
                [
                    'full_path'           => '/var/www/vhosts/SomeOtherProject/src/Foo.php',
                    'hits'                => 19,
                    'memory_consumption'  => 204,
                    'last_used'           => 'Thu Oct 09 16:04:35 2014',
                    'last_used_timestamp' => 1412868715,
                    'timestamp'           => 1412798853,
                ],
                [
                    'full_path'           => '/var/www/vhosts/RedTube/template/humiliation/germany-vs-brazil.phtml',
                    'hits'                => 71,
                    'memory_consumption'  => 7001,
                    'last_used'           => 'Thu Jul 09 21:20:10 2014',
                    'last_used_timestamp' => 1412864715,
                    'timestamp'           => 1412798475,
                ],
                [
                    'full_path'           => '/var/www/vhosts/SomeOtherProject/src/Psr/Autoloader.php',
                    'hits'                => 32,
                    'memory_consumption'  => 4678,
                    'last_used'           => 'Thu Oct 10 15:04:35 2014',
                    'last_used_timestamp' => 1412864715,
                    'timestamp'           => 1412798475,
                ],
                [
                    'full_path'           => '/var/www/vhosts/NoTimeStamp/src/Psr/Autoloader.php',
                    'hits'                => 12876,
                    'memory_consumption'  => 2048,
                    'last_used'           => 'Thu Oct 10 15:04:35 2014',
                    'last_used_timestamp' => 1412864715,
                ],
            ],
        ];
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getStatusInfo
     */
    public function testGetStatusInfo()
    {
        $status = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $this->getMock('\\OpCacheGUI\\I18n\\Translator'),
            $this->statusData
        );

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

        $status = new Status($formatter, $this->getMock('\\OpCacheGUI\\I18n\\Translator'), $this->statusData);

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
        $translator = $this->getMock('\\OpCacheGUI\\I18n\\Translator');
        $translator->method('translate')->will($this->onConsecutiveCalls('Used', 'Free', 'Wasted'));

        $status = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $translator,
            $this->statusData
        );

        $data = [
            [
                'value' => $this->statusData['memory_usage']['used_memory'],
                'color' => '#16a085',
                'label' => 'Used',
            ],
            [
                'value' => $this->statusData['memory_usage']['free_memory'],
                'color' => '#2ecc71',
                'label' => 'Free',
            ],
            [
                'value' => $this->statusData['memory_usage']['wasted_memory'],
                'color' => '#e74c3c',
                'label' => 'Wasted',
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

        $status = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $this->getMock('\\OpCacheGUI\\I18n\\Translator'),
            $statusData
        );

        $data = [
            [
                'num_cached_scripts'   => 0,
                'num_cached_keys'      => 0,
                'max_cached_keys'      => 0,
                'hits'                 => 0,
                'misses'               => 0,
                'blacklist_misses'     => 0,
                'blacklist_miss_ratio' => 'n/a',
            ],
            [
                'opcache_hit_rate'     => 'n/a',
                'start_time'           => 'n/a',
                'last_restart_time'    => 'n/a',
                'oom_restarts'         => 'n/a',
                'hash_restarts'        => 'n/a',
                'manual_restarts'      => 'n/a',
            ]
        ];

        $this->assertSame($data, $status->getStatsInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getStatsInfo
     */
    public function testGetStatsInfoWithOpCacheEnabled()
    {
        $status = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $this->getMock('\\OpCacheGUI\\I18n\\Translator'),
            $this->statusData
        );

        $data = $this->statusData['opcache_statistics'];

        $data['blacklist_miss_ratio'] = 0.0;
        $data['opcache_hit_rate']     = '95.16%';
        $data['start_time']           = '13:41:33 08-10-2014';
        $data['last_restart_time']    = '17:40:00 08-10-2014';

        $formattedData = [
            array_slice($data, 0, 7, true),
            array_slice($data, 7, null, true),
        ];

        $this->assertSame($formattedData, $status->getStatsInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getStatsInfo
     */
    public function testGetStatsInfoWithOpCacheEnabledWithoutRestart()
    {
        $statusData = $this->statusData;

        $statusData['opcache_statistics']['last_restart_time'] = 0;

        $status = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $this->getMock('\\OpCacheGUI\\I18n\\Translator'),
            $statusData
        );

        $data = $this->statusData['opcache_statistics'];

        $data['blacklist_miss_ratio'] = 0.0;
        $data['opcache_hit_rate']     = '95.16%';
        $data['start_time']           = '13:41:33 08-10-2014';
        $data['last_restart_time']    = null;

        $formattedData = [
            array_slice($data, 0, 7, true),
            array_slice($data, 7, null, true),
        ];

        $this->assertSame($formattedData, $status->getStatsInfo());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getGraphKeyStatsInfo
     */
    public function testGetGraphKeyStatsInfo()
    {
        $translator = $this->getMock('\\OpCacheGUI\\I18n\\Translator');
        $translator->method('translate')->will($this->onConsecutiveCalls('Used', 'Free', 'Wasted'));

        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $translator, $this->statusData);

        $data = [
            [
                'value' => 38,
                'color' => '#16a085',
                'label' => 'Used',
            ],
            [
                'value' => 7911,
                'color' => '#2ecc71',
                'label' => 'Free',
            ],
            [
                'value' => 14,
                'color' => '#e74c3c',
                'label' => 'Wasted',
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
        $translator = $this->getMock('\\OpCacheGUI\\I18n\\Translator');
        $translator->method('translate')->will($this->onConsecutiveCalls('Hits', 'Misses', 'Blacklisted'));

        $status = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $translator, $this->statusData);

        $data = [
            [
                'value' => 1160,
                'color' => '#2ecc71',
                'label' => 'Hits',
            ],
            [
                'value' => 59,
                'color' => '#e74c3c',
                'label' => 'Misses',
            ],
            [
                'value' => 0,
                'color' => '#16a085',
                'label' => 'Blacklisted',
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

        $status = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $this->getMock('\\OpCacheGUI\\I18n\\Translator'),
            $statusData
        );

        $this->assertSame([], $status->getCachedScripts());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getCachedScripts
     * @covers OpCacheGUI\OpCache\Status::sortCachedScripts
     */
    public function testGetCachedScriptsFilled()
    {
        $formatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');
        $formatter->method('format')->will($this->onConsecutiveCalls('1KB', '2KB', '3KB', '4KB', '5KB', '6KB'));

        $status = new Status($formatter, $this->getMock('\\OpCacheGUI\\I18n\\Translator'), $this->statusData);

        $data = [
            [
                'full_path'           => '/var/www/vhosts/NoTimeStamp/src/Psr/Autoloader.php',
                'hits'                => 12876,
                'memory_consumption'  => '6KB',
                'last_used_timestamp' => '14:25:15 09-10-2014',
                'timestamp'           => 'N/A',
            ],
            [
                'full_path'           => '/var/www/vhosts/OpcacheGUI/src/OpCacheGUI/Network/Request.php',
                'hits'                => 1,
                'memory_consumption'  => '1KB',
                'last_used_timestamp' => '14:08:35 09-10-2014',
                'timestamp'           => '16:20:53 07-10-2014',
            ],
            [
                'full_path'           => '/var/www/vhosts/OpcacheGUI/template/cached.phtml',
                'hits'                => 4,
                'memory_consumption'  => '2KB',
                'last_used_timestamp' => '14:08:35 09-10-2014',
                'timestamp'           => '16:20:53 07-10-2014',
            ],
            [
                'full_path'           => '/var/www/vhosts/RedTube/template/humiliation/germany-vs-brazil.phtml',
                'hits'                => 71,
                'memory_consumption'  => '4KB',
                'last_used_timestamp' => '14:25:15 09-10-2014',
                'timestamp'           => '20:01:15 08-10-2014',
            ],
            [
                'full_path'           => '/var/www/vhosts/SomeOtherProject/src/Foo.php',
                'hits'                => 19,
                'memory_consumption'  => '3KB',
                'last_used_timestamp' => '15:31:55 09-10-2014',
                'timestamp'           => '20:07:33 08-10-2014',
            ],
            [
                'full_path'           => '/var/www/vhosts/SomeOtherProject/src/Psr/Autoloader.php',
                'hits'                => 32,
                'memory_consumption'  => '5KB',
                'last_used_timestamp' => '14:25:15 09-10-2014',
                'timestamp'           => '20:01:15 08-10-2014',
            ],
        ];

        $this->assertSame($data, $status->getCachedScripts());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getCachedScripts
     */
    public function testGetCachedScriptsZeroedTimestamp()
    {
        $statusData = $this->statusData;

        $statusData['scripts'] = [
            [
                'full_path'           => '/var/www/vhosts/OpcacheGUI/src/OpCacheGUI/Network/Request.php',
                'hits'                => 1,
                'memory_consumption'  => 6608,
                'last_used'           => 'Thu Oct 09 16:08:35 2014',
                'last_used_timestamp' => 1412863715,
                'timestamp'           => 0,
            ],
        ];

        $status = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $this->getMock('\\OpCacheGUI\\I18n\\Translator'),
            $statusData
        );

        $this->assertSame([], $status->getCachedScripts());
    }

    /**
     * @covers OpCacheGUI\OpCache\Status::__construct
     * @covers OpCacheGUI\OpCache\Status::getCachedScriptsForOverview
     * @covers OpCacheGUI\OpCache\Status::getCachedScripts
     * @covers OpCacheGUI\OpCache\Status::sortCachedScripts
     */
    public function testGetCachedScriptsForOverviewFilled()
    {
        $formatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');
        $formatter->method('format')->will($this->onConsecutiveCalls('1KB', '2KB', '3KB', '4KB', '5KB', '6KB'));

        $status = new Status($formatter, $this->getMock('\\OpCacheGUI\\I18n\\Translator'), $this->statusData);

        $data = [
            [
                'full_path'           => '/var/www/vhosts/NoTimeStamp/src/Psr/Autoloader.php',
                'hits'                => 12876,
                'memory_consumption'  => '6KB',
                'last_used_timestamp' => '14:25:15 09-10-2014',
                'timestamp'           => 'N/A',
            ],
            [
                'full_path'           => '/var/www/vhosts/OpcacheGUI/src/OpCacheGUI/Network/Request.php',
                'hits'                => 1,
                'memory_consumption'  => '1KB',
                'last_used_timestamp' => '14:08:35 09-10-2014',
                'timestamp'           => '16:20:53 07-10-2014',
            ],
            [
                'full_path'           => '/var/www/vhosts/OpcacheGUI/template/cached.phtml',
                'hits'                => 4,
                'memory_consumption'  => '2KB',
                'last_used_timestamp' => '14:08:35 09-10-2014',
                'timestamp'           => '16:20:53 07-10-2014',
            ],
            [
                'full_path'           => '/var/www/vhosts/RedTube/template/humiliation/germany-vs-brazil.phtml',
                'hits'                => 71,
                'memory_consumption'  => '4KB',
                'last_used_timestamp' => '14:25:15 09-10-2014',
                'timestamp'           => '20:01:15 08-10-2014',
            ],
            [
                'full_path'           => '/var/www/vhosts/SomeOtherProject/src/Foo.php',
                'hits'                => 19,
                'memory_consumption'  => '3KB',
                'last_used_timestamp' => '15:31:55 09-10-2014',
                'timestamp'           => '20:07:33 08-10-2014',
            ],
            [
                'full_path'           => '/var/www/vhosts/SomeOtherProject/src/Psr/Autoloader.php',
                'hits'                => 32,
                'memory_consumption'  => '5KB',
                'last_used_timestamp' => '14:25:15 09-10-2014',
                'timestamp'           => '20:01:15 08-10-2014',
            ],
        ];

        $trimmer = $this->getMock('\\OpCacheGUI\\Format\\Trimmer');
        $trimmer->method('trim')->will($this->returnArgument(0));

        $this->assertSame($data, $status->getCachedScriptsForOverview($trimmer));
    }

}
