<?php

namespace AlexSabur\OrchidEditorJSField\Fields;

use Orchid\Screen\Field;

/**
 * 
 * @method EditorJS value($value = null)
 */
class EditorJS extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.editorjs';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'tools' => [],
        'value' => [],
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'value',
        'name',
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        $input = (new static())->name($name);

        $input->addBeforeRender(function () {
            $value = $this->get('value');

            if (!is_string($value)) {
                $this->set('value', json_encode($value));
            }
        });

        $input->addBeforeRender(function () {
            $this->set('tools', collect($this->get('tools'))->mapWithKeys(function (EditorJS\Tool $tool) {
                return $tool->toArray();
            })->toJson());
        });

        return $input;
    }

    public function tools($tools = [])
    {
        if (is_array($tools)) {
            $this->attributes['tools'] = $tools;
        } else {
            $this->attributes['tools'] = app($tools)->tools();
        }

        return $this;
    }
}
