import Quill from 'quill';
import $ from 'jquery';

export class Editor {

    readonly PLACEHOLDER = 'Create an awesome post... :)';
    readonly TOOLBAR_OPTIONS = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction

        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'align': [] }],

        ['clean'],                                         // remove formatting button
        ['image']
    ];
    qEditor = new Quill('#editor', {
        theme: 'snow',
        placeholder: this.PLACEHOLDER,
        modules: {
            toolbar: this.TOOLBAR_OPTIONS
        }
    });

    constructor() {
        this.activateEventListeners();
    }

    activateEventListeners() {
        this.copyEditorContentToHiddenInput();
    }

    copyEditorContentToHiddenInput() {
        $('#edit-form').on('submit', (event: Event) => {
            event.preventDefault();
            let editorValue = this.qEditor.root.innerHTML;
            $('#post-content').val(editorValue);
            let form = document.getElementById('edit-form') as HTMLFormElement;
            form.submit();
        });
    }

}
