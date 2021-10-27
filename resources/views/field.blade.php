@component($typeForm, get_defined_vars())
@if ($hidden)
<input type="hidden" {{ $attributes }}>
@else
<div data-controller="editorjs" data-editorjs-tools="{{ $tools }}" data-editorjs-readonly="{{ var_export($readonly, true) }}" data-editorjs-placeholder="{{ $placeholder }}" data-editorjs-min-height="{{ $minHeight }}">
    {{-- @todo data-target="editorjs.holder" -> data-editorjs-target="holder" --}}
    <div data-target="editorjs.holder"></div>
    {{-- @todo data-target="editorjs.input" -> data-editorjs-target="input" --}}
    <input data-target="editorjs.input" type="hidden" {{ $attributes }}>
</div>
@endif
@endcomponent
