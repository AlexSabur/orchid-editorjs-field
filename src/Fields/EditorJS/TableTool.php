<?php

namespace AlexSabur\OrchidEditorJSField\Fields\EditorJS;

/**
 * 
 */
class TableTool extends Tool
{
    /**
     * @var string
     */
    protected $class = 'TableTool';

    public static function make(string $name): self
    {
        return (new static())->name($name);
    }
}
