<?php

namespace AlexSabur\OrchidEditorJSField\Fields\EditorJS;

use Closure;
use Illuminate\Support\Arr;

abstract class Tool
{
    /**
     * Tool name
     * 
     * @var string
     */
    protected $name;

    /**
     * Tool view name
     * 
     * @var string|null
     */
    protected $view;

    /**
     * Tool's class
     * 
     * @var string
     */
    protected $class;

    /**
     * User configuration object that will be passed to the Tool's constructor
     * 
     * @var array
     */
    protected $config = [];

    /**
     * Is need to show Inline Toolbar.
     * Can accept array of Tools for InlineToolbar or boolean.
     * 
     * @var null|boolean|string[]
     */
    protected $inlineToolbar;

    /**
     * Define shortcut that will render Tool
     * 
     * @var null|string
     */
    protected $shortcut;

    /**
     * Tool's Toolbox settings
     * 
     * @var array
     */
    protected $toolbox = [];

    /**
     * 
     * @var array
     */
    protected $data = [];

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

    /**
     * 
     * @param string|null $name 
     * @return $this|null
     */
    public function name($name = null)
    {
        if (is_null($name)) {
            return $this->name;
        }

        $this->name = $name;

        return $this;
    }

    /**
     * 
     * @param array $data 
     * @return $this|null
     */
    public function data(array $data = null)
    {
        if (is_null($data)) {
            return $this->data;
        }

        $this->data = $data;

        return $this;
    }

    /**
     * 
     * @param string $prefix 
     * @return $this 
     */
    public function setPrefix(string $prefix)
    {
        $this->view = "{$prefix}{$this->view}";

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

    /**
     * 
     * @param array|string $key 
     * @param mixed|null $value 
     * @return mixed 
     */
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

        foreach (Arr::dot($params) as $key => $value) {
            if ($value === null) {
                Arr::forget($params, $key);
            }
        }

        if (count($params) == 1) {
            return $this->class;
        }

        return $params;
    }

    public function build()
    {
        if ($this->view) {
            return view($this->view, $this->data);
        }

        return null;
    }

    public function toArray()
    {
        $this->runBeforeConvert();

        return [
            $this->name => $this->params()
        ];
    }
}
