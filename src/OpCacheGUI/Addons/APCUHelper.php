<?php

/**
 * Formatter for byte values
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Addons
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Addons;

/*
  Helper class for APCu variables
  +----------------------------------------------------------------------+
  | APC                                                                  |
  +----------------------------------------------------------------------+
  | Copyright (c) 2006-2011 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Authors: Ralf Becker <beckerr@php.net>                               |
  |          Rasmus Lerdorf <rasmus@php.net>                             |
  |          Ilia Alshanetsky <ilia@prohost.org>                         |
  +----------------------------------------------------------------------+

   All other licensing and usage conditions are those of the PHP Group.
*/
class APCUHelper
{
    private $cacheinfo = array();
    private $generalinfo = array();
    private $runtimesettings = array();
    private $diagram = array();
    
    public $scope_list = array(
        'A' => 'cache_list',
        'D' => 'deleted_list'
    );
    
    public function __construct() 
    {
        $cache = self::getCache();
        $mem = self::getMem();
        
        $time = time();
        $host = php_uname('n');
        $cache['num_hits'] = isset($cache['num_hits']) ? $cache['num_hits'] : $cache['nhits'];
        $cache['num_misses'] = isset($cache['num_misses']) ? $cache['num_misses'] : $cache['nmisses'];
        $cache['start_time'] = isset($cache['start_time']) ? $cache['start_time'] : $cache['stime'];
        $cache['num_inserts'] = isset($cache['num_inserts']) ? $cache['num_inserts'] : $cache['ninserts'];
        $cache['num_entries'] = isset($cache['num_entries']) ? $cache['num_entries'] : $cache['nentries'];
        $cache['num_expunges'] = isset($cache['num_expunges']) ? $cache['num_expunges'] : $cache['nexpunges'];
        
        $mem_size = $mem['num_seg'] * $mem['seg_size'];
        $mem_avail = $mem['avail_mem'];
        $mem_used = $mem_size - $mem_avail;
        $seg_size = self::bsize($mem['seg_size']);
        $number_vars = $cache['num_entries'];
        $size_vars = self::bsize($cache['mem_size']);
        
        $this->cacheinfo['cached_vars'] = "$number_vars ($size_vars)";
        $this->cacheinfo['num_hits'] = $cache['num_hits'];
        $this->cacheinfo['num_misses'] = $cache['num_misses'];
        $this->cacheinfo['req_rate_user'] = sprintf("%.2f", $cache['num_hits'] ? (($cache['num_hits'] + $cache['num_misses']) / ($time - $cache['start_time'])) : 0);
        $this->cacheinfo['hit_rate_user'] = sprintf("%.2f", $cache['num_hits'] ? (($cache['num_hits']) / ($time - $cache['start_time'])) : 0);
        $this->cacheinfo['miss_rate_user'] = sprintf("%.2f", $cache['num_misses'] ? (($cache['num_misses']) / ($time - $cache['start_time'])) : 0);
        $this->cacheinfo['insert_rate_user'] = sprintf("%.2f", $cache['num_inserts'] ? (($cache['num_inserts']) / ($time - $cache['start_time'])) : 0);
        $this->cacheinfo['num_expunges'] = $cache['num_expunges'];
        
        $this->generalinfo['apcversion'] = phpversion('apcu');
        $this->generalinfo['phpversion'] = phpversion();
        if (!empty($_SERVER['SERVER_NAME'])) 
        {
            $this->generalinfo['server_name'] = $_SERVER['SERVER_NAME'];
        }
        if (!empty($_SERVER['SERVER_SOFTWARE'])) 
        {
            $this->generalinfo['server_software'] = $_SERVER['SERVER_SOFTWARE'];
        }
        $this->generalinfo['sharedmemory'] = "{$mem['num_seg']} Segment(s) with $seg_size ({$cache['memory_type']} memory)";
        $this->generalinfo['start_time'] = date('Y/m/d H:i:s', $cache['start_time']);
        $this->generalinfo['uptime'] = self::duration($cache['start_time']);
        $this->generalinfo['file_upload_progress'] = $cache['file_upload_progress'];
        
        $this->runtimesettings = array_map(function ($setting) 
        {
            return $setting['local_value'];
        }
        , ini_get_all('apcu'));
        if ($mem['num_seg'] > 1 || $mem['num_seg'] == 1 && count($mem['block_lists'][0]) > 1) 
        {
            $mem_note = "Memory Usage<br /><font size=-2>(multiple slices indicate fragments)</font>";
        } else
        {
            $mem_note = "Memory Usage";
        }
        
        $nseg = $freeseg = $fragsize = $freetotal = 0;
        for ($i = 0; $i < $mem['num_seg']; $i++) 
        {
            $ptr = 0;
            foreach ($mem['block_lists'][$i] as $block) 
            {
                if ($block['offset'] != $ptr) 
                {
                    ++$nseg;
                }
                $ptr = $block['offset'] + $block['size'];
                
                /* Only consider blocks <5M for the fragmentation % */
                if ($block['size'] < (5 * 1024 * 1024)) $fragsize+= $block['size'];
                $freetotal+= $block['size'];
            }
            $freeseg+= count($mem['block_lists'][$i]);
        }
        
        if ($freeseg > 1) 
        {
            $frag = sprintf("%.2f%% (%s out of %s in %d fragments)", ($fragsize / $freetotal) * 100, self::bsize($fragsize) , self::bsize($freetotal) , $freeseg);
        } else
        {
            $frag = "0%";
        }
        
        $this->diagram[1]['image'] = $mem_note . '<img alt="" width="250" height="210" src="/apcuimg1">';
        $this->diagram[1]['free_memory'] = self::bsize($mem_avail);
        $this->diagram[1]['used_memory'] = self::bsize($mem_used);
        $this->diagram[1]['free'] = '<span class="green box">&nbsp;</span>Free: ' . self::bsize($mem_avail) . sprintf(" (%.1f%%)", $mem_avail * 100 / $mem_size);
        $this->diagram[1]['used'] = '<span class="red box">&nbsp;</span>Used: ' . self::bsize($mem_used) . sprintf(" (%.1f%%)", $mem_used * 100 / $mem_size);
        $this->diagram[2]['image'] = 'Hits and Misses <img alt="" width="230" height="210"  src="/apcuimg2">';
        $this->diagram[2]['hits'] = '<span class="green box">&nbsp;</span>Hits: ' . $cache['num_hits'] . @sprintf(" (%.1f%%)", $cache['num_hits'] * 100 / ($cache['num_hits'] + $cache['num_misses']));
        $this->diagram[2]['misses'] = '<span class="red box">&nbsp;</span>Misses: ' . $cache['num_misses'] . @sprintf(" (%.1f%%)", $cache['num_misses'] * 100 / ($cache['num_hits'] + $cache['num_misses']));
        $this->diagram[3]['image'] = '<div class="fragmentationgraph"><img alt=""  src="/apcuimg3"></div>';
        $this->diagram[3]['fragmentation'] = "Fragmentation: $frag";
    }
    
    public static function getScopeList() 
    {
        return $this->scope_list;
    }
    public function getDiagrams($diagramid) 
    {
        return $this->diagram[$diagramid];
    }
    
    public function getCacheInfo() 
    {
        return $this->cacheinfo;
    }
    
    public function getGeneralInfo() 
    {
        return $this->generalinfo;
    }
    
    public function getRuntimeSettings() 
    {
        return $this->runtimesettings;
    }
    
    public static function getCache() 
    {
        return apcu_cache_info();
    }
    
    public static function getMem() 
    {
        return apcu_sma_info();
    }
    
    public static function duration($ts) 
    {
        global $time;
        $years = (int)((($time - $ts) / (7 * 86400)) / 52.177457);
        $rem = (int)(($time - $ts) - ($years * 52.177457 * 7 * 86400));
        $weeks = (int)(($rem) / (7 * 86400));
        $days = (int)(($rem) / 86400) - $weeks * 7;
        $hours = (int)(($rem) / 3600) - $days * 24 - $weeks * 7 * 24;
        $mins = (int)(($rem) / 60) - $hours * 60 - $days * 24 * 60 - $weeks * 7 * 24 * 60;
        $str = '';
        if ($years == 1) $str.= "$years year, ";
        if ($years > 1) $str.= "$years years, ";
        if ($weeks == 1) $str.= "$weeks week, ";
        if ($weeks > 1) $str.= "$weeks weeks, ";
        if ($days == 1) $str.= "$days day,";
        if ($days > 1) $str.= "$days days,";
        if ($hours == 1) $str.= " $hours hour and";
        if ($hours > 1) $str.= " $hours hours and";
        if ($mins == 1) $str.= " 1 minute";
        else $str.= " $mins minutes";
        return $str;
    }
    
    public static function fill_arc($im, $centerX, $centerY, $diameter, $start, $end, $color1, $color2, $text = '', $placeindex = 0) 
    {
        if (!extension_loaded('gd')) return false;
        $r = $diameter / 2;
        $w = deg2rad((360 + $start + ($end - $start) / 2) % 360);
        
        if (function_exists("imagefilledarc")) 
        {
            
            // exists only if GD 2.0.1 is avaliable
            imagefilledarc($im, $centerX + 1, $centerY + 1, $diameter, $diameter, $start, $end, $color1, IMG_ARC_PIE);
            imagefilledarc($im, $centerX, $centerY, $diameter, $diameter, $start, $end, $color2, IMG_ARC_PIE);
            imagefilledarc($im, $centerX, $centerY, $diameter, $diameter, $start, $end, $color1, IMG_ARC_NOFILL | IMG_ARC_EDGED);
        } else
        {
            imagearc($im, $centerX, $centerY, $diameter, $diameter, $start, $end, $color2);
            imageline($im, $centerX, $centerY, $centerX + cos(deg2rad($start)) * $r, $centerY + sin(deg2rad($start)) * $r, $color2);
            imageline($im, $centerX, $centerY, $centerX + cos(deg2rad($start + 1)) * $r, $centerY + sin(deg2rad($start)) * $r, $color2);
            imageline($im, $centerX, $centerY, $centerX + cos(deg2rad($end - 1)) * $r, $centerY + sin(deg2rad($end)) * $r, $color2);
            imageline($im, $centerX, $centerY, $centerX + cos(deg2rad($end)) * $r, $centerY + sin(deg2rad($end)) * $r, $color2);
            imagefill($im, $centerX + $r * cos($w) / 2, $centerY + $r * sin($w) / 2, $color2);
        }
        if ($text) 
        {
            if ($placeindex > 0) 
            {
                imageline($im, $centerX + $r * cos($w) / 2, $centerY + $r * sin($w) / 2, $diameter, $placeindex * 12, $color1);
                imagestring($im, 4, $diameter, $placeindex * 12, $text, $color1);
            } else
            {
                imagestring($im, 4, $centerX + $r * cos($w) / 2, $centerY + $r * sin($w) / 2, $text, $color1);
            }
        }
    }
    
    public static function text_arc($im, $centerX, $centerY, $diameter, $start, $end, $color1, $text, $placeindex = 0) 
    {
        $r = $diameter / 2;
        $w = deg2rad((360 + $start + ($end - $start) / 2) % 360);
        
        if ($placeindex > 0) 
        {
            imageline($im, $centerX + $r * cos($w) / 2, $centerY + $r * sin($w) / 2, $diameter, $placeindex * 12, $color1);
            imagestring($im, 4, $diameter, $placeindex * 12, $text, $color1);
        } else
        {
            imagestring($im, 4, $centerX + $r * cos($w) / 2, $centerY + $r * sin($w) / 2, $text, $color1);
        }
    }
    
    public static function fill_box($im, $x, $y, $w, $h, $color1, $color2, $text = '', $placeindex = '') 
    {
        global $col_black;
        $x1 = $x + $w - 1;
        $y1 = $y + $h - 1;
        
        imagerectangle($im, $x, $y1, $x1 + 1, $y + 1, $col_black);
        if ($y1 > $y) imagefilledrectangle($im, $x, $y, $x1, $y1, $color2);
        else imagefilledrectangle($im, $x, $y1, $x1, $y, $color2);
        imagerectangle($im, $x, $y1, $x1, $y, $color1);
        if ($text) 
        {
            if ($placeindex > 0) 
            {
                
                if ($placeindex < 16) 
                {
                    $px = 5;
                    $py = $placeindex * 12 + 6;
                    imagefilledrectangle($im, $px + 90, $py + 3, $px + 90 - 4, $py - 3, $color2);
                    imageline($im, $x, $y + $h / 2, $px + 90, $py, $color2);
                    imagestring($im, 2, $px, $py - 6, $text, $color1);
                } else
                {
                    if ($placeindex < 31) 
                    {
                        $px = $x + 40 * 2;
                        $py = ($placeindex - 15) * 12 + 6;
                    } else
                    {
                        $px = $x + 40 * 2 + 100 * intval(($placeindex - 15) / 15);
                        $py = ($placeindex % 15) * 12 + 6;
                    }
                    imagefilledrectangle($im, $px, $py + 3, $px - 4, $py - 3, $color2);
                    imageline($im, $x + $w, $y + $h / 2, $px, $py, $color2);
                    imagestring($im, 2, $px + 2, $py - 6, $text, $color1);
                }
            } else
            {
                imagestring($im, 4, $x + 5, $y1 - 16, $text, $color1);
            }
        }
    }
    
    // pretty printer for byte values
    //
    public static function bsize($s) 
    {
        foreach (array(
            '',
            'K',
            'M',
            'G'
        ) as $i => $k) 
        {
            if ($s < 1024) break;

            
            $s/= 1024;
        }
        return sprintf("%5.1f %sBytes", $s, $k);
    }
    
    // sortable table header in "scripts for this host" view
    public static function sortheader($key, $name, $extra = '') 
    {
        global $MYREQUEST, $MY_SELF_WO_SORT;
        
        if ($MYREQUEST['SORT1'] == $key) 
        {
            $MYREQUEST['SORT2'] = $MYREQUEST['SORT2'] == 'A' ? 'D' : 'A';
        }
        return "<a class=sortable href=\"$MY_SELF_WO_SORT$extra&SORT1=$key&SORT2=" . $MYREQUEST['SORT2'] . "\">$name</a>";
    }
    
    // create menu entry
    public static function menu_entry($ob, $title) 
    {
        global $MYREQUEST, $MY_SELF;
        if ($MYREQUEST['OB'] != $ob) 
        {
            return "<li><a href=\"$MY_SELF&OB=$ob\">$title</a></li>";
        } else if (empty($MYREQUEST['SH'])) 
        {
            return "<li><span class=active>$title</span></li>";
        } else
        {
            return "<li><a class=\"child_active\" href=\"$MY_SELF&OB=$ob\">$title</a></li>";
        }
    }
    
    public static function nice_size($number) 
    {
        if ($number > (1024 * 1024)) 
        {
            return intval($number / (1024 * 1024)) . 'M';
        } else if ($number > 1024) 
        {
            return intval($number / 1024) . 'K';
        } else
        {
            return $number;
        }
    }
    
    public static function put_login_link($s = "Login") 
    {
        global $MY_SELF, $MYREQUEST, $AUTHENTICATED;
        
        // needs ADMIN_PASSWORD to be changed!
        //
        if (!USE_AUTHENTICATION) 
        {
            return;
        } else if (ADMIN_PASSWORD == 'password') 
        {
            print <<<EOB
            <a href="#" onClick="javascript:alert('You need to set a password at the top of apc.php before this will work!');return false";>$s</a>
EOB;
            
            
        } else if ($AUTHENTICATED) 
        {
            print <<<EOB
            '{$_SERVER['PHP_AUTH_USER']}'&nbsp;logged&nbsp;in!
EOB;
            
            
        } else
        {
            print <<<EOB
            <a href="$MY_SELF&LO=1&OB={$MYREQUEST['OB']}">$s</a>
EOB;
            
            
        }
    }
    
    public static function block_sort($array1, $array2) 
    {
        if ($array1['offset'] > $array2['offset']) 
        {
            return 1;
        } else
        {
            return -1;
        }
    }
    
    public static function createimg($imgid, $output = 'img') 
    {
        define('GRAPH_SIZE', 200);
        
        // Image size
        $size = GRAPH_SIZE;
        $mem = self::getMem();
        $cache = self::getCache();
        
        // image size
        if ($imgid == 3) $image = imagecreate(2 * $size + 150, $size + 10);
        else $image = imagecreate($size + 50, $size + 10);
        
        $col_white = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
        $col_red = imagecolorallocate($image, 0xD0, 0x60, 0x30);
        $col_green = imagecolorallocate($image, 0x60, 0xF0, 0x60);
        $col_black = imagecolorallocate($image, 0, 0, 0);
        imagecolortransparent($image, $col_white);
        
        switch ($imgid) 
        {
        case 1:
            $s = $mem['num_seg'] * $mem['seg_size'];
            $a = $mem['avail_mem'];
            $x = $y = $size / 2;
            $fuzz = 0.000001;
            $json_array = [];
            
            // This block of code creates the pie chart.  It is a lot more complex than you
            // would expect because we try to visualize any memory fragmentation as well.
            $angle_from = 0;
            $string_placement = array();
            for ($i = 0; $i < $mem['num_seg']; $i++) 
            {
                $ptr = 0;
                $free = $mem['block_lists'][$i];
                uasort($free, 'self::block_sort');
                
                foreach ($free as $block) 
                {
                    if ($block['offset'] != $ptr) 
                    {
                        
                        // Used block
                        $angle_to = $angle_from + ($block['offset'] - $ptr) / $s;
                        if (($angle_to + $fuzz) > 1) $angle_to = 1;
                        if (($angle_to * 360) - ($angle_from * 360) >= 1) 
                        {
                            self::fill_arc($image, $x, $y, $size, $angle_from * 360, $angle_to * 360, $col_black, $col_red);
                            if (($angle_to - $angle_from) > 0.05) 
                            {
                                array_push($string_placement, array(
                                    $angle_from,
                                    $angle_to
                                ));
                            }
                            $json_array[] = ['value' => $block['size'], 'color' => '#D06030'];
                        }
                        $angle_from = $angle_to;
                    }
                    $angle_to = $angle_from + ($block['size']) / $s;
                    if (($angle_to + $fuzz) > 1) $angle_to = 1;
                    if (($angle_to * 360) - ($angle_from * 360) >= 1) 
                    {
                        self::fill_arc($image, $x, $y, $size, $angle_from * 360, $angle_to * 360, $col_black, $col_green);
                        if (($angle_to - $angle_from) > 0.05) 
                        {
                            array_push($string_placement, array(
                                $angle_from,
                                $angle_to
                            ));
                        }
                        $json_array[] = ['value' => $block['size'], 'color' => '#60F060'];
                    }
                    $angle_from = $angle_to;
                    $ptr = $block['offset'] + $block['size'];
                }
                if ($ptr < $mem['seg_size']) 
                {
                    
                    // memory at the end
                    $angle_to = $angle_from + ($mem['seg_size'] - $ptr) / $s;
                    if (($angle_to + $fuzz) > 1) $angle_to = 1;
                    self::fill_arc($image, $x, $y, $size, $angle_from * 360, $angle_to * 360, $col_black, $col_red);
                    if (($angle_to - $angle_from) > 0.05) 
                    {
                        array_push($string_placement, array(
                            $angle_from,
                            $angle_to
                        ));
                    }
                    $json_array[] = ['value' => $block['size'], 'color' => '#D06030'];
                }
            }
            
            foreach ($string_placement as $angle) 
            {
                self::text_arc($image, $x, $y, $size, $angle[0] * 360, $angle[1] * 360, $col_black, self::bsize($s * ($angle[1] - $angle[0])));
            }
            break;

        case 2:
            $cache['num_hits'] = isset($cache['num_hits']) ? $cache['num_hits'] : $cache['nhits'];
            $cache['num_misses'] = isset($cache['num_misses']) ? $cache['num_misses'] : $cache['nmisses'];
            $s = $cache['num_hits'] + $cache['num_misses'];
            $a = $cache['num_hits'];
            
            self::fill_box($image, 30, $size, 50, $s ? (-$a * ($size - 21) / $s) : 0, $col_black, $col_green, sprintf("%.1f%%", $s ? $cache['num_hits'] * 100 / $s : 0));
            self::fill_box($image, 130, $size, 50, $s ? -max(4, ($s - $a) * ($size - 21) / $s) : 0, $col_black, $col_red, sprintf("%.1f%%", $s ? $cache['num_misses'] * 100 / $s : 0));
            break;

        case 3:
            $s = $mem['num_seg'] * $mem['seg_size'];
            $a = $mem['avail_mem'];
            $x = 130;
            $y = 1;
            $j = 1;
            
            // This block of code creates the bar chart.  It is a lot more complex than you
            // would expect because we try to visualize any memory fragmentation as well.
            for ($i = 0; $i < $mem['num_seg']; $i++) 
            {
                $ptr = 0;
                $free = $mem['block_lists'][$i];
                uasort($free, 'self::block_sort');
                foreach ($free as $block) 
                {
                    if ($block['offset'] != $ptr) 
                    {
                        
                        // Used block
                        $h = (GRAPH_SIZE - 5) * ($block['offset'] - $ptr) / $s;
                        if ($h > 0) 
                        {
                            $j++;
                            if ($j < 75) self::fill_box($image, $x, $y, 50, $h, $col_black, $col_red, self::bsize($block['offset'] - $ptr) , $j);
                            else self::fill_box($image, $x, $y, 50, $h, $col_black, $col_red);
                        }
                        $y+= $h;
                    }
                    $h = (GRAPH_SIZE - 5) * ($block['size']) / $s;
                    if ($h > 0) 
                    {
                        $j++;
                        if ($j < 75) self::fill_box($image, $x, $y, 50, $h, $col_black, $col_green, self::bsize($block['size']) , $j);
                        else self::fill_box($image, $x, $y, 50, $h, $col_black, $col_green);
                    }
                    $y+= $h;
                    $ptr = $block['offset'] + $block['size'];
                }
                if ($ptr < $mem['seg_size']) 
                {
                    
                    // memory at the end
                    $h = (GRAPH_SIZE - 5) * ($mem['seg_size'] - $ptr) / $s;
                    if ($h > 0) 
                    {
                        self::fill_box($image, $x, $y, 50, $h, $col_black, $col_red, self::bsize($mem['seg_size'] - $ptr) , $j++);
                    }
                }
            }
            break;

        case 4:
            $s = $cache['num_hits'] + $cache['num_misses'];
            $a = $cache['num_hits'];
            
            self::fill_box($image, 30, $size, 50, $s ? -$a * ($size - 21) / $s : 0, $col_black, $col_green, sprintf("%.1f%%", $s ? $cache['num_hits'] * 100 / $s : 0));
            self::fill_box($image, 130, $size, 50, $s ? -max(4, ($s - $a) * ($size - 21) / $s) : 0, $col_black, $col_red, sprintf("%.1f%%", $s ? $cache['num_misses'] * 100 / $s : 0));
            break;
        }
        if ($output == 'img') 
        {
            header("Content-type: image/png");
            imagepng($image);
            exit;
        } else
        {
            return json_encode($json_array);
        }
    }
    
    /**
     * Gets the memory info formatted to build a graph
     *
     * @return string JSON encoded memory info
     */
    public function getGraphMemoryInfo() 
    {
        $memory = $this->statusData['memory_usage'];
        
        return json_encode([['value' => $memory['wasted_memory'], 'color' => '#e0642e', ], ['value' => $memory['used_memory'], 'color' => '#2e97e0', ], ['value' => $memory['free_memory'], 'color' => '#bce02e', ], ]);
    }
}
