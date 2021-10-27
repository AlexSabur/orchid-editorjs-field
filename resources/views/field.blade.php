@component($typeForm, get_defined_vars())
<div data-controller="editorjs" data-editorjs-tools="{{ $tools }}">
    {{-- @todo data-target="editorjs.holder" -> data-editorjs-target="holder" --}}
    <div data-target="editorjs.holder"></div>
    {{-- @todo data-target="editorjs.input" -> data-editorjs-target="input" --}}
    <input data-target="editorjs.input" type="hidden" @attributes($attributes)>
</div>
@endcomponent