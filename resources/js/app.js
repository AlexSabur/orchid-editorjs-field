import FieldsEditorJS from './controllers/fields/editorjs_controller';

if (typeof window.application !== 'undefined') {
    window.application.register('fields--editorjs', FieldsEditorJS);
}