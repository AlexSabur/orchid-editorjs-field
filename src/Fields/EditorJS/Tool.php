<?php

namespace AlexSabur\OrchidEditorJSField\Fields\EditorJS;

use Closure;

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

    public function inlineToolbar($inlineToolbar = null)
    {
        $this->inlineToolbar = $inlineToolbar;

        return $this;
    }

    public function shortcut($shortcut = null)
    {
        $this->shortcut = $shortcut;

        return $this;
    }

    public function config($data = [])
    {
        $this->config = array_merge($this->config, $data);

        return $this;
    }

    /**
     * @param Closure $closure
     *
     * @return static
     */
    public function addBeforeConvert(Closure $closure)
    {
        $this->beforeConvert[] = $closure;

        return $this;
    }

    /**
     * Alternately performs all tasks.
     *
     * @return $this
     */
    public function runBeforeConvert(): self
    {
        foreach ($this->beforeConvert as $convert) {
            $convert->call($this);
        }

        return $this;
    }

    public function params()
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
