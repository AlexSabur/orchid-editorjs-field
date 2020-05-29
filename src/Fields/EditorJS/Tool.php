<?php

namespace AlexSabur\OrchidEditorJSField\Fields\EditorJS;

use Closure;
use Illuminate\Support\Arr;

abstract class Tool
{
    protected $name;

    /**
     * Tool's class
     */
    protected $class;

    /**
     * User configuration object that will be passed to the Tool's constructor
     */
    protected $config = [];

    /**
     * Is need to show Inline Toolbar.
     * Can accept array of Tools for InlineToolbar or boolean.
     */
    protected $inlineToolbar;

    /**
     * Define shortcut that will render Tool
     */
    protected $shortcut;

    /**
     * Tool's Toolbox settings
     */
    protected $toolbox = [];

    /**
     * A set of closure functions
     * that must be executed before data is displayed.
     *
     * @var Closure[]
     */
    private $beforeConvert = [];

    public static function make(string $name): self
    {
        return (new static())->name($name);
    }

    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * 
     * @param string[]|bool $value 
     * @return $this 
     */
    public function inlineToolbar($value = null)
    {
        $this->inlineToolbar = $value;

        return $this;
    }

    /**
     * 
     * @param string $shortcut 
     * @return $this 
     */
    public function shortcut($shortcut = null)
    {
        $this->shortcut = $shortcut;

        return $this;
    }

    public function config($key, $value = null)
    {
        if (is_array($key)) {
            $this->config = array_merge($this->config, $key);
        } else if ($value === null) {
            return Arr::get($this->config, $key);
        } else {
            Arr::set($this->config, $key, $value);
        }

        return $this;
    }

    /**
     * @param Closure $closure
     *
     * @return static
     */
    protected function addBeforeConvert(Closure $closure)
    {
        $this->beforeConvert[] = $closure;

        return $this;
    }

    /**
     * Alternately performs all tasks.
     *
     * @return $this
     */
    protected function runBeforeConvert(): self
    {
        foreach ($this->beforeConvert as $convert) {
            $convert->call($this);
        }

        return $this;
    }

    protected function params()
    {
        $params = [
            'class' => $this->class,
            'inlineToolbar' => $this->inlineToolbar,
            'shortcut' => $this->shortcut,
            'config' => $this->config,
        ];

        foreach ($params as $key => $value) {
            if ($value === null || (is_array($value) && count($value) === 0)) {
                unset($params[$key]);
            }
        }

        if (count($params) == 1) {
            return $this->class;
        }

        return $params;
    }

    public function toArray()
    {
        $this->runBeforeConvert();

        return [
            $this->name => $this->params()
        ];
    }
}
