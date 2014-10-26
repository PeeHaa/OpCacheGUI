<?php

namespace OpCacheGUITest\Unit\APCu;

use OpCacheGUI\APCu\Status;

class StatusTest extends \PHPUnit_Framework_TestCase
{
    protected $statusData;

    protected $testData;

    protected function setUp()
    {
        $this->statusData = [
            'start_time' => 1,
        ];

        $this->testData = [
            'enabled'             => 1,
            'file_upload_support' => 1,
            'start_time'          => '01-01-1970 00:00:01',
            'uptime'              => '1',
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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

        $this->assertSame($this->testData['file_upload_support'], $config->getStatusInfo()['file_upload_support']);
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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

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

        $config = new Status($this->getMock('\\OpCacheGUI\\Format\\Byte'), $configuration, $this->statusData);

        $this->assertSame('5 years 2 months 3 hours and 5 minutes', $config->getStatusInfo()['uptime']);
    }
}
