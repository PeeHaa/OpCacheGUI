<?php
/**
 * Cycles through CSS classes
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Presentation;

/**
 * Cycles through CSS classes
 *
 * @category   OpCacheGUI
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class ClassCycler
{
    /**
     * @var array List of classes to cycle through
     */
    private $classes;

    /**
     * @var int The current position
     */
    private $position = 0;

    /**
     * Creates instance
     *
     * @param array $classes List of classes to cycle through
     */
    public function __construct(array $classes)
    {
        $this->classes = array_values($classes);
    }

    /**
     * Gets the next class
     *
     * @return string The class
     */
    public function next()
    {
        if ($this->position === count($this->classes)) {
            $this->rewind();
        }

        return $this->classes[$this->position++];
    }

    /**
     * Sets the position to start position
     */
    public function rewind()
    {
        $this->position = 0;
    }
}
