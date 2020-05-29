<?php

namespace AlexSabur\OrchidEditorJSField\Fields\EditorJS;

class ImageTool extends Tool
{
    /**
     * @var string
     */
    protected $class = 'ImageTool';

    protected $config = [
        'endpoints' => [
            'byFile' => '#',
            'byUrl' => '#',
        ]
    ];

    public static function make(string $name): self
    {
        $tool = (new static())->name($name);

        $tool->addBeforeConvert(function () {
            if ($this->config('endpoints.byFile') === '#') {
                $this->config('endpoints.byFile', url()->route('platform.systems.editorjs.image-by-file'));
            }
        });

        $tool->addBeforeConvert(function () {
            if ($this->config('endpoints.byUrl') === '#') {
                $this->config('endpoints.byUrl', url()->route('platform.systems.editorjs.image-by-url'));
            }
        });

        $tool->addBeforeConvert(function () {
            $this->config('additionalRequestHeaders.X-CSRF-TOKEN', csrf_token());
        });

        return $tool;
    }

    /**
     * 
     * @param array|string $key 
     * @param string|null $value 
     * @return $this 
     */
    public function endpoints($key, $value = null)
    {
        if (is_array($key)) {
            $this->config('endpoints', $key);
        } else {
            $this->config("endpoints.{$key}", $value);
        }

        return $this;
    }
}
