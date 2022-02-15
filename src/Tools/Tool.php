<?php

namespace AlexSabur\OrchidEditorJSField\Tools;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Orchid\Screen\Concerns\Makeable;

abstract class Tool implements Arrayable
{
    use Makeable;

    /**
     * Name of tool.
     *
     * @var null|string
     */
    protected $name;

    /**
     * Javascript class Name.
     *
     * @var mixed
     */
    protected $class;

    /**
     * Is tune flag.
     *
     * @var bool|null
     */
    protected $isGlobalTune;

    /**
     * @var null|bool|array
     *
     * @see https://editorjs.io/enable-inline-toolbar#enable-inline-toolbar
     */
    protected $inlineToolbar;

    /**
     * @var null|string
     *
     * @see https://editorjs.io/enable-inline-toolbar#enable-inline-toolbar
     */
    protected $shortcut;

    protected $toolbox;

    protected $defaultConfig = [];

    protected $config = [];

    protected $tunes = [];

    public function __construct()
    {
        $this->config = $this->getDefaultConfig();
    }

    public function name(?string $name = null)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name ?: Str::lower(Str::beforeLast(class_basename($this), 'Tool'));
    }

    public function getClass()
    {
        return $this->class ?: class_basename($this);
    }

    public function getDefaultConfig()
    {
        return $this->defaultConfig;
    }

    /**
     * @param  Closure|array  $config
     * @param  bool  $merge
     * @return $this
     */
    public function setConfig($config, $merge = true)
    {
        if (is_callable($config)) {
            $config = $config($this->config);
        }

        $this->config = $merge
            ? array_merge_recursive($this->config, $config)
            : $config;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setInlineToolbar($value)
    {
        $this->inlineToolbar = $value;

        return $this;
    }

    public function getInlineToolbar()
    {
        return $this->inlineToolbar;
    }

    public function setShortcut($value)
    {
        $this->shortcut = $value;

        return $this;
    }

    public function getShortcut()
    {
        return $this->shortcut;
    }

    public function setIsGlobalTune($value)
    {
        $this->isGlobalTune = $value;

        return $this;
    }

    public function getIsGlobalTune()
    {
        return $this->isGlobalTune;
    }

    public function setTunes($value)
    {
        $this->tunes = $value;

        return $this;
    }

    public function getTunes()
    {
        return $this->tunes;
    }

    public function setToolbox($value)
    {
        $this->toolbox = $value;

        return $this;
    }

    public function getToolbox()
    {
        return $this->toolbox;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $parameters = [
            'class' => $this->getClass(),
        ];

        if (filled($config = $this->getConfig())) {
            $parameters['config'] = $config;
        }

        if (filled($inlineToolbar = $this->getInlineToolbar())) {
            $parameters['inlineToolbar'] = $inlineToolbar;
        }

        if (filled($shortcut = $this->getShortcut())) {
            $parameters['shortcut'] = $shortcut;
        }

        if (filled($toolbox = $this->getToolbox())) {
            $parameters['toolbox'] = $toolbox;
        }

        if (filled($tunes = $this->getTunes())) {
            $parameters['tunes'] = $tunes;
        }

        if (filled($isGlobalTune = $this->getIsGlobalTune())) {
            $parameters['isGlobalTune'] = $isGlobalTune;
        }

        return $parameters;
    }
}
