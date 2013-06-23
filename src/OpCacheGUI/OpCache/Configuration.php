<?php
/**
 * Container for the configuration of OpCache
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    OpCache
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\OpCache;

use OpCacheGUI\Format\Byte;

/**
 * Container for the configuration of OpCache
 *
 * @category   OpCacheGUI
 * @package    OpCache
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Configuration
{
    /**
     * @var array The (unfiltered) output of opcache_get_configuration()`
     */
    private $configData;

    /**
     * @var \OpCacheGUI\Format\Byte Formatter of byte values
     */
    private $byteFormatter;

    /**
     * Creates instance
     *
     * @param \OpCacheGUI\Format\Byte $byteFormatter Formatter of byte values
     */
    public function __construct(Byte $byteFormatter)
    {
        $this->byteFormatter = $byteFormatter;
        $this->configData    = opcache_get_configuration();
    }

    /**
     * Gets the ini direcyivesof OpCache
     *
     * @return array The ini directives
     */
    public function getIniDirectives()
    {
        $directives = $this->configData['directives'];

        return [
            'opcache.enable'                  => $directives['opcache.enable'],
            'opcache.enable_cli'              => $directives['opcache.enable_cli'],
            'opcache.use_cwd'                 => $directives['opcache.use_cwd'],
            'opcache.validate_timestamps'     => $directives['opcache.validate_timestamps'],
            'opcache.inherited_hack'          => $directives['opcache.inherited_hack'],
            'opcache.dups_fix'                => $directives['opcache.dups_fix'],
            'opcache.revalidate_path'         => $directives['opcache.revalidate_path'],
            'opcache.log_verbosity_level'     => $directives['opcache.log_verbosity_level'],
            'opcache.memory_consumption'      => $this->byteFormatter->format($directives['opcache.memory_consumption']),
            'opcache.interned_strings_buffer' => $directives['opcache.interned_strings_buffer'],
            'opcache.max_accelerated_files'   => $directives['opcache.max_accelerated_files'],
            'opcache.max_wasted_percentage'   => $directives['opcache.max_wasted_percentage'],
            'opcache.consistency_checks'      => $directives['opcache.consistency_checks'],
            'opcache.force_restart_timeout'   => $directives['opcache.force_restart_timeout'],
            'opcache.revalidate_freq'         => $directives['opcache.revalidate_freq'],
            'opcache.preferred_memory_model'  => $directives['opcache.preferred_memory_model'],
            'opcache.blacklist_filename'      => $directives['opcache.blacklist_filename'],
            'opcache.max_file_size'           => $directives['opcache.max_file_size'],
            'opcache.error_log'               => $directives['opcache.error_log'],
            'opcache.protect_memory'          => $directives['opcache.protect_memory'],
            'opcache.save_comments'           => $directives['opcache.save_comments'],
            'opcache.load_comments'           => $directives['opcache.load_comments'],
            'opcache.fast_shutdown'           => $directives['opcache.fast_shutdown'],
            'opcache.enable_file_override'    => $directives['opcache.enable_file_override'],
            'opcache.optimization_level'      => $directives['opcache.optimization_level'],
        ];
    }

    /**
     * Gets blacklisted files
     *
     * @return array List of blacklisted files
     */
    public function getBlackList()
    {
        return $this->configData['blacklist'];
    }
}
