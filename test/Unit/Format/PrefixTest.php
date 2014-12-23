<?php

namespace OpCacheGUITest\Unit\Format;

use OpCacheGUI\Format\Prefix;

class PrefixTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testConstructCorrectInstance()
    {
        $prefix = new Prefix;

        $this->assertInstanceOf('\\OpCacheGUI\\Format\\Trimmer', $prefix);
    }

    /**
     * @covers OpCacheGUI\Format\Prefix::trim
     * @covers OpCacheGUI\Format\Prefix::getPrefixLength
     * @covers OpCacheGUI\Format\Prefix::findLongestPrefix
     */
    public function testTrimWithoutCommonPrefix()
    {
        $prefix = new Prefix;

        $data = [
            [
                'full_path' => '/foo/bar/baz.php',
            ],
            [
                'full_path' => 'bar/baz.php',
            ],
        ];

        $this->assertSame($data, $prefix->trim($data));
    }

    /**
     * @covers OpCacheGUI\Format\Prefix::trim
     * @covers OpCacheGUI\Format\Prefix::getPrefixLength
     * @covers OpCacheGUI\Format\Prefix::findLongestPrefix
     */
    public function testTrimWithoutCommonPrefixEarlyReturn()
    {
        $prefix = new Prefix;

        $data = [
            [
                'full_path' => '/foo/bar/baz.php',
            ],
            [
                'full_path' => 'bar/baz.php',
            ],
            [
                'full_path' => 'bar/qux.php',
            ],
        ];

        $this->assertSame($data, $prefix->trim($data));
    }

    /**
     * @covers OpCacheGUI\Format\Prefix::trim
     * @covers OpCacheGUI\Format\Prefix::getPrefixLength
     * @covers OpCacheGUI\Format\Prefix::findLongestPrefix
     */
    public function testTrimWithCommonPrefixPath()
    {
        $prefix = new Prefix;

        $data = [
            [
                'full_path' => '/foo/yay/more/and/deeper/xbar/baz.php',
            ],
            [
                'full_path' => '/foo/yay/more/and/deeper/ybaz.php',
            ],
        ];

        $result = [
            [
                'full_path' => '/xbar/baz.php',
            ],
            [
                'full_path' => '/ybaz.php',
            ],
        ];

        $this->assertSame($result, $prefix->trim($data));
    }

    /**
     * @covers OpCacheGUI\Format\Prefix::trim
     * @covers OpCacheGUI\Format\Prefix::getPrefixLength
     * @covers OpCacheGUI\Format\Prefix::findLongestPrefix
     */
    public function testTrimWithCommonPrefixNonPath()
    {
        $prefix = new Prefix;

        $data = [
            [
                'full_path' => '/foo/bar/baz.php',
            ],
            [
                'full_path' => '/foo/baz.php',
            ],
        ];

        $result = [
            [
                'full_path' => '/bar/baz.php',
            ],
            [
                'full_path' => '/baz.php',
            ],
        ];

        $this->assertSame($result, $prefix->trim($data));
    }

    /**
     * @covers OpCacheGUI\Format\Prefix::trim
     * @covers OpCacheGUI\Format\Prefix::getPrefixLength
     * @covers OpCacheGUI\Format\Prefix::findLongestPrefix
     */
    public function testTrimWithCommonPrefixPathWindowsDirectorySeparator()
    {
        $prefix = new Prefix;

        $data = [
            [
                'full_path' => '\foo\yay\more\and\deeper\xbar\baz.php',
            ],
            [
                'full_path' => '\foo\yay\more\and\deeper\ybaz.php',
            ],
        ];

        $result = [
            [
                'full_path' => '\xbar\baz.php',
            ],
            [
                'full_path' => '\ybaz.php',
            ],
        ];

        $this->assertSame($result, $prefix->trim($data));
    }

    /**
     * @covers OpCacheGUI\Format\Prefix::trim
     * @covers OpCacheGUI\Format\Prefix::getPrefixLength
     * @covers OpCacheGUI\Format\Prefix::findLongestPrefix
     */
    public function testTrimWithCommonPrefixNonPathWindowsDirectorySeparator()
    {
        $prefix = new Prefix;

        $data = [
            [
                'full_path' => '\foo\bar\baz.php',
            ],
            [
                'full_path' => '\foo\baz.php',
            ],
        ];

        $result = [
            [
                'full_path' => '\bar\baz.php',
            ],
            [
                'full_path' => '\baz.php',
            ],
        ];

        $this->assertSame($result, $prefix->trim($data));
    }

    /**
     * @covers OpCacheGUI\Format\Prefix::trim
     * @covers OpCacheGUI\Format\Prefix::getPrefixLength
     * @covers OpCacheGUI\Format\Prefix::findLongestPrefix
     */
    public function testTrimWithCommonPrefixExactMatch()
    {
        $prefix = new Prefix;

        $data = [
            [
                'full_path' => '/foo/bar/baz.php',
            ],
            [
                'full_path' => '/foo/bar/baz.php',
            ],
        ];

        $result = [
            [
                'full_path' => '',
            ],
            [
                'full_path' => '',
            ],
        ];

        $this->assertSame($result, $prefix->trim($data));
    }
}
