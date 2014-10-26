<?php

namespace OpCacheGUITest\Unit\APCu;

use OpCacheGUI\APCu\Status;

class StatusTest extends \PHPUnit_Framework_TestCase
{
    protected $statusData;

    protected $memStatus;

    protected $testData;

    protected function setUp()
    {
        $this->statusData = [
            'start_time'   => 1,
            'mem_size'     => 1168,
            'num_entries'  => 2,
            'num_hits'     => 40,
            'num_misses'   => 10,
            'num_inserts'  => 2,
            'num_expunges' => 1,
            'version'      => '4.0.7',
        ];

        $this->memStatus = [
            'num_seg'     => 1,
            'seg_size'    => 33554336,
            'avail_mem'   => 33536608,
            'block_lists' => [
                [
                    [
                        'size'   => 33536592,
                        'offset' => 17808,
                    ],
                ],
            ],
        ];

        $this->testData = [
            'enabled'             => 1,
            'file_upload_support' => 1,
            'start_time'          => '01-01-1970 00:00:01',
            'uptime'              => '1',
            'version'             => '4.0.7',
        ];
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     */
    public function testGetStatusInfoApcEnabled()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 0,
        ]);

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame($this->testData['enabled'], $config->getStatusInfo()['enabled']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     */
    public function testGetStatusInfoFileUploadSupportEnabled()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame($this->testData['file_upload_support'], $config->getStatusInfo()['file_upload_support']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     */
    public function testGetStatusInfoVersion()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame($this->testData['version'], $config->getStatusInfo()['version']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     */
    public function testGetStatusStartTime()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame($this->testData['start_time'], $config->getStatusInfo()['start_time']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     * @covers OpCacheGUI\APCu\Status::getTimeAgo
     */
    public function testGetStatusTimeAgoMinute()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $startTime = new \DateTime();
        $startTime->sub(new \DateInterval('PT1M'));

        $this->statusData['start_time'] = $startTime->format('U');

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('1 minute', $config->getStatusInfo()['uptime']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     * @covers OpCacheGUI\APCu\Status::getTimeAgo
     */
    public function testGetStatusTimeAgoMinutes()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $startTime = new \DateTime();
        $startTime->sub(new \DateInterval('PT5M'));

        $this->statusData['start_time'] = $startTime->format('U');

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('5 minutes', $config->getStatusInfo()['uptime']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     * @covers OpCacheGUI\APCu\Status::getTimeAgo
     */
    public function testGetStatusTimeAgoHourAndMinutes()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $startTime = new \DateTime();
        $startTime->sub(new \DateInterval('PT1H5M'));

        $this->statusData['start_time'] = $startTime->format('U');

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('1 hour and 5 minutes', $config->getStatusInfo()['uptime']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     * @covers OpCacheGUI\APCu\Status::getTimeAgo
     */
    public function testGetStatusTimeAgoHoursAndMinutes()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $startTime = new \DateTime();
        $startTime->sub(new \DateInterval('PT3H5M'));

        $this->statusData['start_time'] = $startTime->format('U');

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('3 hours and 5 minutes', $config->getStatusInfo()['uptime']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     * @covers OpCacheGUI\APCu\Status::getTimeAgo
     */
    public function testGetStatusTimeAgoMonthAndHoursAndMinutes()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $startTime = new \DateTime();
        $startTime->sub(new \DateInterval('P1MT3H5M'));

        $this->statusData['start_time'] = $startTime->format('U');

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('1 month 3 hours and 5 minutes', $config->getStatusInfo()['uptime']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     * @covers OpCacheGUI\APCu\Status::getTimeAgo
     */
    public function testGetStatusTimeAgoMonthsAndHoursAndMinutes()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $startTime = new \DateTime();
        $startTime->sub(new \DateInterval('P2MT3H5M'));

        $this->statusData['start_time'] = $startTime->format('U');

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('2 months 3 hours and 5 minutes', $config->getStatusInfo()['uptime']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     * @covers OpCacheGUI\APCu\Status::getTimeAgo
     */
    public function testGetStatusTimeAgoYearMonthsAndHoursAndMinutes()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $startTime = new \DateTime();
        $startTime->sub(new \DateInterval('P1Y2MT3H5M'));

        $this->statusData['start_time'] = $startTime->format('U');

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('1 year 2 months 3 hours and 5 minutes', $config->getStatusInfo()['uptime']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatusInfo
     * @covers OpCacheGUI\APCu\Status::getTimeAgo
     */
    public function testGetStatusTimeAgoYearsMonthsAndHoursAndMinutes()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $configuration->method('getIniDirectives')->willReturn([
            'apc.enabled' => 1,
            'apc.rfc1867' => 1,
        ]);

        $startTime = new \DateTime();
        $startTime->sub(new \DateInterval('P5Y2MT3H5M'));

        $this->statusData['start_time'] = $startTime->format('U');

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('5 years 2 months 3 hours and 5 minutes', $config->getStatusInfo()['uptime']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getMemoryInfo
     */
    public function testGetMemoryInfoTotalMemory()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame($this->memStatus['seg_size'], $config->getMemoryInfo()['total_memory']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getMemoryInfo
     */
    public function testGetMemoryInfoUsedMemory()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame(
            $config->getMemoryInfo()['total_memory'] - $this->memStatus['avail_mem'],
            $config->getMemoryInfo()['used_memory']
        );
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getMemoryInfo
     */
    public function testGetMemoryInfoFreeMemory()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame($this->memStatus['avail_mem'], $config->getMemoryInfo()['free_memory']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getMemoryInfo
     * @covers OpCacheGUI\APCu\Status::getFragmentationPercent
     */
    public function testGetMemoryInfoFragmentationPercent()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('0.00%', $config->getMemoryInfo()['fragmentation_percent']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getMemoryInfo
     * @covers OpCacheGUI\APCu\Status::getFragmentationPercent
     */
    public function testGetMemoryInfoFragmentationPercentBlockSmallerThenMinimum()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->memStatus['block_lists'][0][0]['size'] = 3353;

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('100.00%', $config->getMemoryInfo()['fragmentation_percent']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getMemoryInfo
     * @covers OpCacheGUI\APCu\Status::getFragmentationBytes
     */
    public function testGetMemoryInfoFragmentationBytes()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame(0, $config->getMemoryInfo()['fragmentation_bytes']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getMemoryInfo
     * @covers OpCacheGUI\APCu\Status::getFragmentationBytes
     */
    public function testGetMemoryInfoFragmentationBytesBlockSmallerThenMinimum()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->memStatus['block_lists'][0][0]['size'] = 3353;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame(3353, $config->getMemoryInfo()['fragmentation_bytes']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getMemoryInfo
     * @covers OpCacheGUI\APCu\Status::getFragmentationSegments
     */
    public function testGetMemoryInfoFragmentationSegments()
    {
        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config = new Status(
            $this->getMock('\\OpCacheGUI\\Format\\Byte'),
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame(1, $config->getMemoryInfo()['fragmentation_fragments']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     */
    public function testGetStatsInfoCachedVars()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('2 (1168)', $config->getStatsInfo()['cached_vars']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     */
    public function testGetStatsInfoNumHits()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame($this->statusData['num_hits'], $config->getStatsInfo()['num_hits']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     */
    public function testGetStatsInfoNumMisses()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame($this->statusData['num_misses'], $config->getStatsInfo()['num_misses']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     * @covers OpCacheGUI\APCu\Status::getRequestRate
     */
    public function testGetStatsInfoRequestRateZero()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->statusData['num_hits'] = 0;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('0.00', $config->getStatsInfo()['req_rate_user']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     * @covers OpCacheGUI\APCu\Status::getRequestRate
     */
    public function testGetStatsInfoRequestRateFilled()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $datetime = new \DateTime();
        $datetime->sub(new \DateInterval('PT1M'));

        $this->statusData['start_time'] = $datetime->format('U');

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('0.83', $config->getStatsInfo()['req_rate_user']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     * @covers OpCacheGUI\APCu\Status::getHitRate
     */
    public function testGetStatsInfoHitRateZero()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->statusData['num_hits'] = 0;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('0.00', $config->getStatsInfo()['hit_rate_user']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     * @covers OpCacheGUI\APCu\Status::getHitRate
     */
    public function testGetStatsInfoHitRateFilled()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $datetime = new \DateTime();
        $datetime->sub(new \DateInterval('PT1M'));

        $this->statusData['start_time'] = $datetime->format('U');

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('0.67', $config->getStatsInfo()['hit_rate_user']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     * @covers OpCacheGUI\APCu\Status::getMissRate
     */
    public function testGetStatsInfoMissRateZero()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->statusData['num_misses'] = 0;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('0.00', $config->getStatsInfo()['miss_rate_user']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     * @covers OpCacheGUI\APCu\Status::getMissRate
     */
    public function testGetStatsInfoMissRateFilled()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $datetime = new \DateTime();
        $datetime->sub(new \DateInterval('PT1M'));

        $this->statusData['start_time'] = $datetime->format('U');

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('0.17', $config->getStatsInfo()['miss_rate_user']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     * @covers OpCacheGUI\APCu\Status::getInsertRate
     */
    public function testGetStatsInfoInsertRateZero()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->statusData['num_inserts'] = 0;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('0.00', $config->getStatsInfo()['insert_rate_user']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     * @covers OpCacheGUI\APCu\Status::getInsertRate
     */
    public function testGetStatsInfoInsertRateFilled()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $datetime = new \DateTime();
        $datetime->sub(new \DateInterval('PT1M'));

        $this->statusData['start_time'] = $datetime->format('U');

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame('0.03', $config->getStatsInfo()['insert_rate_user']);
    }

    /**
     * @covers OpCacheGUI\APCu\Status::__construct
     * @covers OpCacheGUI\APCu\Status::getStatsInfo
     */
    public function testGetStatsInfoNumExpunges()
    {
        $byteFormatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');

        $byteFormatter->method('format')->will($this->returnArgument(0));

        $configuration = $this->getMockBuilder('\\OpCacheGUI\\APCu\\Configuration')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config = new Status(
            $byteFormatter,
            $configuration,
            $this->statusData,
            $this->memStatus
        );

        $this->assertSame($this->statusData['num_expunges'], $config->getStatsInfo()['num_expunges']);
    }
}
