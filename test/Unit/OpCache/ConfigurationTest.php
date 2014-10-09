<?php

namespace OpCacheGUITest\OpCache;

use OpCacheGUI\OpCache\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    protected $configData;

    protected function setUp()
    {
        $this->configData = [
            'directives' => [
                'opcache.enable'                  => true,
                'opcache.enable_cli'              => false,
                'opcache.use_cwd'                 => true,
                'opcache.validate_timestamps'     => true,
                'opcache.inherited_hack'          => true,
                'opcache.dups_fix'                => false,
                'opcache.revalidate_path'         => false,
                'opcache.log_verbosity_level'     => 1,
                'opcache.memory_consumption'      => 134217728,
                'opcache.interned_strings_buffer' => 8,
                'opcache.max_accelerated_files'   => 4000,
                'opcache.max_wasted_percentage'   => 0.05,
                'opcache.consistency_checks'      => 0,
                'opcache.force_restart_timeout'   => 180,
                'opcache.revalidate_freq'         => 60,
                'opcache.preferred_memory_model'  => '',
                'opcache.blacklist_filename'      => '',
                'opcache.max_file_size'           => 0,
                'opcache.error_log'               => '',
                'opcache.protect_memory'          => false,
                'opcache.save_comments'           => false,
                'opcache.load_comments'           => true,
                'opcache.fast_shutdown'           => true,
                'opcache.enable_file_override'    => true,
                'opcache.optimization_level'      => 2147483647,
            ],
            'version' => [
                'version'              => '7.0.2-dev',
                'opcache_product_name' => 'Zend OPcache',
            ],
            'blacklist' => [
                '/var/www/vhosts/OpCacheGUI/src/OpCacheGUI/Presentation/Html.php'
            ],
        ];
    }

    /**
     * @covers OpCacheGUI\OpCache\Configuration::__construct
     * @covers OpCacheGUI\OpCache\Configuration::getIniDirectives
     */
    public function testGetIniDirectives()
    {
        $formatter = $this->getMock('\\OpCacheGUI\\Format\\Byte');
        $formatter->method('format')->willReturn('1KB');

        $config = new Configuration($formatter, $this->configData);

        $this->configData['directives']['opcache.memory_consumption'] = '1KB';

        $this->assertSame($this->configData['directives'], $config->getIniDirectives());
    }

    /**
     * @covers OpCacheGUI\OpCache\Configuration::__construct
     * @covers OpCacheGUI\OpCache\Configuration::getBlackList
     */
    public function testGetBlackList()
    {
        $config = new Configuration($this->getMock('\\OpCacheGUI\\Format\\Byte'), $this->configData);

        $this->assertSame($this->configData['blacklist'], $config->getBlackList());
    }
}
