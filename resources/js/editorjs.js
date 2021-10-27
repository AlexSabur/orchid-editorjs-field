import FieldsEditorJS from './editorjs-controller';

if (typeof window.application !== 'undefined') {
    window.application.register('editorjs', FieldsEditorJS);
}
