<?php

namespace OpCacheGUITest\Unit\Presentation;

use OpCacheGUI\Presentation\ClassCycler;

class ClassCyclerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Presentation\ClassCycler::__construct
     * @covers OpCacheGUI\Presentation\ClassCycler::next
     */
    public function testNextFirst()
    {
        $cycler = new ClassCycler([1, 2]);

        $this->assertSame(1, $cycler->next());
    }

    /**
     * @covers OpCacheGUI\Presentation\ClassCycler::__construct
     * @covers OpCacheGUI\Presentation\ClassCycler::next
     */
    public function testNextMultiple()
    {
        $cycler = new ClassCycler([1, 2]);

        $this->assertSame(1, $cycler->next());
        $this->assertSame(2, $cycler->next());
    }

    /**
     * @covers OpCacheGUI\Presentation\ClassCycler::__construct
     * @covers OpCacheGUI\Presentation\ClassCycler::next
     * @covers OpCacheGUI\Presentation\ClassCycler::rewind
     */
    public function testNextOverflows()
    {
        $cycler = new ClassCycler([1, 2]);

        $this->assertSame(1, $cycler->next());
        $this->assertSame(2, $cycler->next());
        $this->assertSame(1, $cycler->next());
    }

    /**
     * @covers OpCacheGUI\Presentation\ClassCycler::__construct
     * @covers OpCacheGUI\Presentation\ClassCycler::next
     * @covers OpCacheGUI\Presentation\ClassCycler::rewind
     */
    public function testRewind()
    {
        $cycler = new ClassCycler([1, 2]);

        $this->assertSame(1, $cycler->next());
        $cycler->rewind();
        $this->assertSame(1, $cycler->next());
    }
}
