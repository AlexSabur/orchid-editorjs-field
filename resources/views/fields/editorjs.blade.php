@component($typeForm, get_defined_vars())
    <div
        data-controller="fields--editorjs"
        data-fields--editorjs-tools="{{$tools}}"
    >
        <div class="editorjs"></div>
        <input type="hidden" @attributes($attributes)>
    </div>
@endcomponent
