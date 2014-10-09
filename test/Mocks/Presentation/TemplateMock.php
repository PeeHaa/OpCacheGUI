<?php

namespace OpCacheGUITest\Mocks\Presentation;

use OpCacheGUI\Presentation\Template;

class TemplateMock extends Template
{
    public function render($template, array $data = [])
    {
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $this->variables[$key] = $value;
    }
}
