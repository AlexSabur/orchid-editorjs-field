<?php

namespace AlexSabur\OrchidEditorJSField\Fields\EditorJS;

/**
 * 
 */
class EmbedTool extends Tool
{
    /**
     * @var string
     */
    protected $class = 'EmbedTool';

    public static function make(string $name): self
    {
        return (new static())->name($name);
    }
}
