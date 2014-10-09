<?php
/**
 * The class is responsible for rendering HTML templates
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

use OpCacheGUI\I18n\Translator;

/**
 * The class is responsible for rendering HTML templates
 *
 * @category   OpCacheGUI
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Html extends Template
{
    /**
     * @var string The base (skeleton) page in which all templates will get rendered
     */
    private $baseTemplate;

    /**
     * @var \OpCacheGUI\Presentation\UrlRenderer Instance of an URI renderer
     */
    private $url;

    /**
     * Creates instance
     *
     * @param string                               $templateDirectory The directory where all the templates are stored
     * @param string                               $baseTemplate      The base (skeleton) page in which all templates
     *                                                                will get rendered
     * @param \OpCacheGUI\I18n\Translator          $translator        The translation service
     * @param \OpCacheGUI\Presentation\UrlRenderer $url               Instance of an URI renderer
     */
    public function __construct($templateDirectory, $baseTemplate, Translator $translator, UrlRenderer $url)
    {
        parent::__construct($templateDirectory, $translator);

        $this->baseTemplate = $baseTemplate;
        $this->url          = $url;
    }

    /**
     * Renders a template
     *
     * @param string $template The template to render
     * @param array  $data     The data to use in the template
     */
    public function render($template, array $data = [])
    {
        $this->variables = $data;

        $this->variables['content'] = $this->renderTemplate($template);

        return $this->renderTemplate($this->baseTemplate);
    }

    /**
     * Renders the template file using output buffering
     *
     * @param string $template The template to render
     *
     * @return string The rendered template
     */
    private function renderTemplate($template)
    {
        ob_start();
        require $this->templateDirectory . '/' . $template;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
