<?php

namespace AlexSabur\OrchidEditorJSField\Tools;

class ImageTool extends Tool
{
    /**
     * @var string
     */
    protected $class = 'ImageTool';

    public function getDefaultConfig()
    {
        return [
            'endpoints' => [
                'byFile' => route('platform.systems.editorjs.image-by-file'),
                'byUrl' => route('platform.systems.editorjs.image-by-url'),
            ],
            'additionalRequestHeaders' => [
                'X-CSRF-TOKEN' => csrf_token(),
            ],
        ];
    }
}
