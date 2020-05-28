<?php

namespace AlexSabur\OrchidEditorJSField\Fields\EditorJS;

/**
 * 
 */
class ParagraphTool extends Tool
{
    /**
     * @var string
     */
    protected $class = 'ParagraphTool';

    public static function make(string $name): self
    {
        return (new static())->name($name);
    }
}
