<?php

namespace AlexSabur\OrchidEditorJSField\Tools;

class LinkTool extends Tool
{
    /**
     * @var string
     */
    protected $class = 'LinkTool';

    public function getDefaultConfig()
    {
        return [
            'endpoint' => route('platform.systems.editorjs.link'),
        ];
    }
}
