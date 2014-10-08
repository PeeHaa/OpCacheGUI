<?php

namespace OpCacheGUITest\Mocks\Presentation;

use OpCacheGUI\Presentation\Template;

class TemplateMock extends Template
{
    public function render($template, array $data = [])
    {
    }

    public function set($key, $value)
    {
        $this->variables[$key] = $value;
    }
}
