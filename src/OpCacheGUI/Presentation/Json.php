<?php
/**
 * The class is responsible for rendering JSON templates
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Presentation;

/**
 * The class is responsible for rendering JSON templates
 *
 * @category   OpCacheGUI
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Json extends Template
{
    /**
     * Renders a template
     *
     * @param string $template The template to render
     * @param array  $data     The data to use in the template
     */
    public function render($template, array $data = [])
    {
        $this->variables = $data;

        return require $this->templateDirectory . '/' . $template;
    }
}
