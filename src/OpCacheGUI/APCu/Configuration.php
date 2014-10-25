<?php
/**
 * Container for the configuration of APCu
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

/**
 * Container for the configuration of APCu
 *
 * @category   OpCacheGUI
 * @package    APCu
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Configuration
{
    /**
     * @var array The (unfiltered) output of ini_get_all('apcu', false)
     */
    private $configData;

    /**
     * Creates instance
     *
     * @param array $configData The configuration data from APCu
     */
    public function __construct(array $configData)
    {
        $this->configData = $configData;
    }

    /**
     * Gets the ini directives of APCu
     *
     * @return array The ini directives
     */
    public function getIniDirectives()
    {
        $mmap_file_mask = null;

        if (isset($this->configData['apc.mmap_file_mask'])) {
            $mmap_file_mask = $this->configData['apc.mmap_file_mask'];
        }

        return [
            'apc.enabled'          => $this->configData['apc.enabled'],
            'apc.enable_cli'       => $this->configData['apc.enable_cli'],
            'apc.writable'         => $this->configData['apc.writable'],
            'apc.preload_path'     => $this->configData['apc.preload_path'],
            'apc.serializer'       => $this->configData['apc.serializer'],
            'apc.entries_hint'     => $this->configData['apc.entries_hint'],
            'apc.ttl'              => $this->configData['apc.ttl'],
            'apc.use_request_time' => $this->configData['apc.use_request_time'],
            'apc.gc_ttl'           => $this->configData['apc.gc_ttl'],
            'apc.smart'            => $this->configData['apc.smart'],
            'apc.slam_defense'     => $this->configData['apc.slam_defense'],
            'apc.shm_segments'     => $this->configData['apc.shm_segments'],
            'apc.shm_size'         => $this->configData['apc.shm_size'],
            'apc.coredump_unmap'   => $this->configData['apc.coredump_unmap'],
            'apc.mmap_file_mask'   => $mmap_file_mask,
            'apc.rfc1867'          => $this->configData['apc.rfc1867'],
            'apc.rfc1867_freq'     => $this->configData['apc.rfc1867_freq'],
            'apc.rfc1867_name'     => $this->configData['apc.rfc1867_name'],
            'apc.rfc1867_prefix'   => $this->configData['apc.rfc1867_prefix'],
            'apc.rfc1867_ttl'      => $this->configData['apc.rfc1867_ttl'],
        ];
    }
}
