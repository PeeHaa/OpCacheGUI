<?php

namespace OpCacheGUITest\Unit\APCu;

use OpCacheGUI\APCu\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    protected $configData;

    protected function setUp()
    {
        $this->configData = [
            'apc.enabled'          => 1,
            'apc.enable_cli'       => 1,
            'apc.writable'         => '/tmp',
            'apc.preload_path'     => null,
            'apc.serializer'       => 'php',
            'apc.entries_hint'     => 4096,
            'apc.ttl'              => 7200,
            'apc.use_request_time' => 1,
            'apc.gc_ttl'           => 3600,
            'apc.smart'            => 0,
            'apc.slam_defense'     => 1,
            'apc.shm_segments'     => 1,
            'apc.shm_size'         => '32M',
            'apc.coredump_unmap'   => 0,
            'apc.mmap_file_mask'   => null,
            'apc.rfc1867'          => 0,
            'apc.rfc1867_freq'     => 0,
            'apc.rfc1867_name'     => 'APC_UPLOAD_PROGRESS',
            'apc.rfc1867_prefix'   => 'upload_',
            'apc.rfc1867_ttl'      => 3600,
        ];
    }

    /**
     * @covers OpCacheGUI\APCu\Configuration::__construct
     * @covers OpCacheGUI\APCu\Configuration::getIniDirectives
     */
    public function testGetIniDirectives()
    {
        $config = new Configuration($this->configData);

        $this->assertSame($this->configData, $config->getIniDirectives());
    }

    /**
     * @covers OpCacheGUI\APCu\Configuration::__construct
     * @covers OpCacheGUI\APCu\Configuration::getIniDirectives
     */
    public function testGetIniDirectivesWithuotMMAPSupport()
    {
        $data = $this->configData;

        unset($data['apc.mmap_file_mask']);

        $config = new Configuration($data);

        $this->configData['apc.mmap_file_mask'] = null;

        $this->assertSame($this->configData, $config->getIniDirectives());
    }
}
