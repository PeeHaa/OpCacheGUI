<?php

$texts = [
    'project.link'   => 'GitHub链接',
    'project.log_in' => '登录',

    'error.not.installed.title'       => '未安装',
    'error.not.installed.description' => 'OpCache 未安装',
    'error.not.enabled.title'         => '未开启',
    'error.not.enabled.description'   => 'OpCache 未开启',

    'menu.status'    => '状态',
    'menu.config'    => '配置',
    'menu.scripts'   => '缓存脚本',
    'menu.graphs'    => '图表',
    'menu.visualise' => '可视化',

    'reset.submit'       => '重置',
    'confirmation.reset' => '你确定要重置缓存？',
    'confirmation.yes'   => '是',
    'confirmation.no'    => '否',

    'status.title'               => '状态',
    'status.opcache_enabled'     => '允许',
    'status.cache_full'          => '缓存已满',
    'status.restart_pending'     => '重启中',
    'status.restart_in_progress' => '重启进度',

    'memory.title'                     => '内存',
    'memory.used_memory'               => '已使用',
    'memory.free_memory'               => '空闲',
    'memory.wasted_memory'             => '闲置内存',
    'memory.current_wasted_percentage' => '当前闲置',

    'stats.title'                => 'Opcache 统计',
    'stats.num_cached_scripts'   => '缓存脚本',
    'stats.num_cached_keys'      => 'Cached keys',
    'stats.max_cached_keys'      => 'Max cached keys',
    'stats.hits'                 => '命中',
    'stats.start_time'           => '开始时间',
    'stats.last_restart_time'    => '最近一次重启',
    'stats.oom_restarts'         => 'Oom 重启',
    'stats.hash_restarts'        => 'Hash 重启',
    'stats.manual_restarts'      => '手动重启',
    'stats.misses'               => '未命中',
    'stats.blacklist_misses'     => '黑名单未命中',
    'stats.blacklist_miss_ratio' => '未命中率',
    'stats.opcache_hit_rate'     => '命中率',

    'config.title'                                             => '配置',
    'config.opcache.enable'                                    => 'Enabled',
    'config.opcache.enable.description'                        => '确认是否启用了Zend Opcache',
    'config.opcache.enable_cli'                                => 'Enabled for CLI',
    'config.opcache.enable_cli.description'                    => '确定是否为CLI版本的PHP启用了Zend OPCache.',
    'config.opcache.use_cwd'                                   => 'Keys based on current working dir',
    'config.opcache.use_cwd.description'                       => '启用此指令后，OPcache会将当前工作目录附加到脚本目录中，从而消除可能在具有相同名称（basename）的文件之间发生冲突。 禁用该指令可以提高性能，但可能会破坏现有应用程序.',
    'config.opcache.validate_timestamps'                       => 'Validate timestamps',
    'config.opcache.validate_timestamps.description'           => '禁用时，必须手动重置OPcache或重新启动Web服务器以使文件系统的更改生效.',
    'config.opcache.dups_fix'                                  => 'Dups fix',
    'config.opcache.dups_fix.description'                      => '这个hack应该只能解决“无法重新声明类”错误.',
    'config.opcache.revalidate_path'                           => 'Revalidate path',
    'config.opcache.revalidate_path.description'               => '在include_path优化中启用或禁用文件搜索.',
    'config.opcache.log_verbosity_level'                       => 'Log verbosity level',
    'config.opcache.log_verbosity_level.description'           => '所有OPcache错误都会转到Web服务器日志。 默认情况下，仅记录fatal errors（level0）或errors（level1）。 您还可以启用warnings（level2），info messages（level3）或debug messages（level4）.',
    'config.opcache.memory_consumption'                        => 'Opcache memory size',
    'config.opcache.memory_consumption.description'            => 'OPcache共享内存的存储大小.',
    'config.opcache.interned_strings_buffer'                   => 'Interned strings buffer',
    'config.opcache.interned_strings_buffer.description'       => 'The amount of memory for interned strings in Mbytes.',
    'config.opcache.max_accelerated_files'                     => 'Maximum cached scripts',
    'config.opcache.max_accelerated_files.description'         => 'OPcache哈希表中的最大脚本数。 仅允许介于200和100000之间的数字.',
    'config.opcache.max_wasted_percentage'                     => 'Maximum wasted before restart',
    'config.opcache.max_wasted_percentage.description'         => '计划重新启动之前“wasted”内存的最大百分比.',
    'config.opcache.consistency_checks'                        => 'Consistency checks frequency',
    'config.opcache.consistency_checks.description'            => '检查每个N请求的缓存校验和。 默认值“0”表示禁用检查.',
    'config.opcache.force_restart_timeout'                     => 'Force restart timeout',
    'config.opcache.force_restart_timeout.description'         => '如果未访问缓存，则等待多少秒以便开始计划的重新启动.',
    'config.opcache.revalidate_freq'                           => 'Frequency to check for changes',
    'config.opcache.revalidate_freq.description'               => '检查文件时间戳以更改共享内存存储分配的频率（以秒为单位）。 “1”表示每秒验证一次，但每次请求只验证一次。 “0”表示始终验证.',
    'config.opcache.preferred_memory_model'                    => 'Preferred memory model',
    'config.opcache.preferred_memory_model.description'        => '首选共享内存后端。 留空，让系统决定.',
    'config.opcache.blacklist_filename'                        => 'Blacklist',
    'config.opcache.blacklist_filename.description'            => 'OPcache黑名单文件的位置（允许使用通配符）。 每个OPcache黑名单文件都是一个文本文件，其中包含不应加速的文件的名称。 文件格式是将每个文件名添加到新行。 文件名可以是完整路径或只是文件前缀（即/var/www/x 将/var/www/中以\'x\'开头的所有文件和目录列入黑名单）。以a开头的行将被忽略.',
    'config.opcache.max_file_size'                             => 'Exclude caching above size',
    'config.opcache.max_file_size.description'                 => '允许排除大文件被缓存。 默认情况下，所有文件都被缓存.',
    'config.opcache.error_log'                                 => 'Error log',
    'config.opcache.error_log.description'                     => 'OPcache error_log文件名。 空字符串暂定为“stderr”.',
    'config.opcache.protect_memory'                            => 'Protect memory',
    'config.opcache.protect_memory.description'                => '在脚本执行期间保护共享内存不被意外写入。 仅用于内部调试.',
    'config.opcache.save_comments'                             => 'Save comments',
    'config.opcache.save_comments.description'                 => 'If disabled, all PHPDoc comments are dropped from the code to reduce the size of the optimized code.',
    'config.opcache.fast_shutdown'                             => 'Fast shutdown',
    'config.opcache.fast_shutdown.description'                 => 'If enabled, a fast shutdown sequence is used for the accelerated code.',
    'config.opcache.enable_file_override'                      => 'File override',
    'config.opcache.enable_file_override.description'          => 'Allow file existence override (file_exists, etc.) performance feature.',
    'config.opcache.optimization_level'                        => 'Optimization level',
    'config.opcache.optimization_level.description'            => 'A bitmask, where each bit enables or disables the appropriate OPcache passes.',
    'config.opcache.mmap_base'                                 => 'Mmap base',
    'config.opcache.mmap_base.description'                     => '用于Windows上共享内存段的基础。 所有PHP进程都必须将共享内存映射到相同的地址空间。 使用此指令允许修复“无法重新连接到基址”错误.',
    'config.opcache.restrict_api'                              => 'Restrict API',
    'config.opcache.restrict_api.description'                  => '允许仅从PHP脚本调用OPcache API函数，该路径从指定的字符串开始。 默认值“”表示没有限制.',
    'config.opcache.file_update_protection'                    => 'File update protection',
    'config.opcache.file_update_protection.description'        => '防止缓存小于此秒数的文件。 它可以防止未完全更新的文件的缓存。 如果您站点上的所有文件更新都是原子的，您可以通过将其设置为“0”来提高性能.',
    'config.opcache.huge_code_pages'                           => 'Huge code pages',
    'config.opcache.huge_code_pages.description'               => '启用或禁用将PHP代码（文本段）复制到HUGE PAGES中。 这应该可以提高性能，但需要适当的OS配置.',
    'config.opcache.lockfile_path'                             => 'Lockfile path',
    'config.opcache.lockfile_path.description'                 => '用于存储共享锁文件的绝对路径 (for *nix only)',
    'config.opcache.file_cache'                                => 'File cache',
    'config.opcache.file_cache.description'                    => '启用并设置二级缓存目录。 当SHM内存已满，服务器重启或SHM重置时，它应该可以提高性能。 默认的“”禁用基于文件的缓存.',
    'config.opcache.file_cache_only'                           => 'File cache only',
    'config.opcache.file_cache_only.description'               => '启用或禁用共享内存中的opcode caching.',
    'config.opcache.file_cache_consistency_checks'             => 'File cache consistency checks',
    'config.opcache.file_cache_consistency_checks.description' => '从文件高速缓存加载脚本时启用或禁用校验和验证.',
    'config.opcache.file_cache_fallback'                       => 'File cache fallback',
    'config.opcache.file_cache_fallback.description'           => '对于无法重新连接到共享内存的某个进程（仅适用于Windows），意味着opcache.file_cache_only = 1。 需要显式启用文件缓存.',
    'config.opcache.validate_permission'                       => 'Validate permission',
    'config.opcache.validate_permission.description'           => '验证针对当前用户的缓存文件权限.',
    'config.opcache.validate_root'                             => 'Validate root',
    'config.opcache.validate_root.description'                 => '防止chroot环境中的名称冲突。 这应该在所有chroot的环境中启用，以防止访问chroot外的文件.',

    'blacklist.title' => '黑名单',
    'blacklist.empty' => '没有脚本在黑名单中',

    'scripts.title'                  => '缓存脚本',
    'scripts.overview.title'         => '概览',
    'scripts.empty'                  => '没有脚本被缓存',
    'scripts.directory.script_count' => ' (<i class="count">%s</i> 文件)',
    'scripts.full_path'              => '文件名',
    'scripts.hits'                   => '命中',
    'scripts.memory_consumption'     => '内存',
    'scripts.last_used_timestamp'    => '最近一次使用时间',
    'scripts.timestamp'              => '创建',
    'scripts.actions'                => 'Actions',
    'script.invalidate'              => '无效',
    'scripts.filter.placeholder'     => '过滤缓存脚本',

    'graph.title'          => '图表',
    'graph.memory.title'   => '内存',
    'graph.memory.free'    => '空闲',
    'graph.memory.used'    => '使用',
    'graph.memory.wasted'  => 'wasted',
    'graph.keys.title'     => 'Keys',
    'graph.keys.free'      => '空闲',
    'graph.keys.scripts'   => 'used',
    'graph.keys.wasted'    => 'wasted',
    'graph.hits.title'     => '命中',
    'graph.hits.hits'      => 'hits',
    'graph.hits.misses'    => 'misses',
    'graph.hits.blacklist' => '黑名单',

    'visualise.title' => '缓存可视化分区显示',

];
