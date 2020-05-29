<?php

namespace AlexSabur\OrchidEditorJSField\Fields\EditorJS;

class LinkTool extends Tool
{
    /**
     * @var string
     */
    protected $class = 'LinkTool';

    protected $config = [
        'endpoint' => '#'
    ];

    public static function make(string $name): self
    {
        $tool = (new static())->name($name);

        $tool->addBeforeConvert(function () {
            if ($this->config('endpoint') === '#') {
                $this->config('endpoint', url()->route('platform.systems.editorjs.link'));
            };
        });

        return $tool;
    }
}
