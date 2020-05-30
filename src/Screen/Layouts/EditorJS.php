<?php

namespace AlexSabur\OrchidEditorJSField\Screen\Layouts;

use AlexSabur\OrchidEditorJSField\Fields\EditorJS\Tool;
use Illuminate\Support\Arr;
use Orchid\Screen\Layouts\Base;
use Orchid\Screen\Repository;

abstract class EditorJS extends Base
{

    /**
     * @var string
     */
    protected $template = 'platform::layouts.tool';

    protected $prefix = 'platform::fields.editorjs.';

    /**
     * Data source
     * 
     * @var string|null
     */
    public $target = null;

    /**
     * @param Repository $repository
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        if (!$this->checkPermission($this, $repository)) {
            return;
        }

        $data = $this->getData($repository);

        $blocks = collect($data)->map(function ($item) {
            return optional($this->getTool($item['type']), function (Tool $tool) use ($item) {
                return $tool->data($item['data'])->setPrefix($this->prefix);
            });
        })->filter();

        return view($this->template, [
            'blocks' => $blocks,
        ]);
    }

    /**
     * 
     * @param Repository $repository 
     * @return array 
     */
    public function getData(Repository $repository)
    {
        $data = isset($this->target) ? $repository->getContent($this->target) : [];

        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        } elseif (is_string($data)) {
            $data = json_decode($data, true);
        }

        return Arr::get($data, 'blocks', []);
    }

    /**
     * 
     * @param string $name 
     * @return Tool|null 
     */
    protected function getTool(string $name)
    {
        return collect($this->tools())->first(function (Tool $tool) use ($name) {
            return $tool->name() == $name;
        });
    }

    /**
     * 
     * @return Tool[] 
     */
    abstract public function tools(): array;
}
