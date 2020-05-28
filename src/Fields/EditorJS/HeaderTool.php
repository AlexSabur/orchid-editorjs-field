<?php

namespace AlexSabur\OrchidEditorJSField\Fields\EditorJS;

/**
 * 
 * @method HeaderTool placeholder($value = '')
 * @method HeaderTool levels($value = [])
 * @method HeaderTool defaultLevel($value = null)
 */
class HeaderTool extends Tool
{
    /**
     * @var string
     */
    protected $class = 'HeaderTool';

    public static function make(string $name): self
    {
        return (new static())->name($name);
    }
}
