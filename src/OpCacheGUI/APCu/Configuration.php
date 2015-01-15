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
            $mmap_file_mask = $this->configData['apc.mmap_file_mask']['local_value'];
        }

        return [
            'apc.enabled'          => $this->configData['apc.enabled']['local_value'],
            'apc.enable_cli'       => $this->configData['apc.enable_cli']['local_value'],
            'apc.writable'         => $this->configData['apc.writable']['local_value'],
            'apc.preload_path'     => $this->configData['apc.preload_path']['local_value'],
            'apc.serializer'       => $this->configData['apc.serializer']['local_value'],
            'apc.entries_hint'     => $this->configData['apc.entries_hint']['local_value'],
            'apc.ttl'              => $this->configData['apc.ttl']['local_value'],
            'apc.use_request_time' => $this->configData['apc.use_request_time']['local_value'],
            'apc.gc_ttl'           => $this->configData['apc.gc_ttl']['local_value'],
            'apc.smart'            => $this->configData['apc.smart']['local_value'],
            'apc.slam_defense'     => $this->configData['apc.slam_defense']['local_value'],
            'apc.shm_segments'     => $this->configData['apc.shm_segments']['local_value'],
            'apc.shm_size'         => $this->configData['apc.shm_size']['local_value'],
            'apc.coredump_unmap'   => $this->configData['apc.coredump_unmap']['local_value'],
            'apc.mmap_file_mask'   => $mmap_file_mask,
            'apc.rfc1867'          => $this->configData['apc.rfc1867']['local_value'],
            'apc.rfc1867_freq'     => $this->configData['apc.rfc1867_freq']['local_value'],
            'apc.rfc1867_name'     => $this->configData['apc.rfc1867_name']['local_value'],
            'apc.rfc1867_prefix'   => $this->configData['apc.rfc1867_prefix']['local_value'],
            'apc.rfc1867_ttl'      => $this->configData['apc.rfc1867_ttl']['local_value'],
        ];
    }
}
