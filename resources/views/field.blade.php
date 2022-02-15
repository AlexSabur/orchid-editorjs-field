@component($typeForm, get_defined_vars())
@if ($hidden)
<input type="hidden" {{ $attributes }}>
@else
<div data-controller="editorjs" data-editorjs-tools="{{ $tools }}" data-editorjs-readonly="{{ var_export($readonly, true) }}" data-editorjs-placeholder="{{ $placeholder }}" data-editorjs-min-height="{{ $minHeight }}">
    <div data-editorjs-target="holder"></div>
    <input data-editorjs-target="input" type="hidden" {{ $attributes }}>
</div>
@endif
@endcomponent
