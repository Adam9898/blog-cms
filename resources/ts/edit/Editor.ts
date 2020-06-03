import Quill from 'quill';
import $ from 'jquery';
import {BlogPost} from "../models/BlogPost";
import {validateOrReject} from "class-validator";

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
        this.qEditor.root.innerHTML = $('#post-content').val() as string;
    }

    activateEventListeners() {
        this.copyEditorContentToHiddenInput();
    }

    copyEditorContentToHiddenInput() {
        $('#edit-form').on('submit', (event: Event) => {
            event.preventDefault();
            let title = $('#blog-title').val() as string;
            let editorValue = this.qEditor.root.innerHTML;
            let post = new BlogPost(title, editorValue);
            $('#post-content').val(post.content);
            this.validatePost(post);
        });
    }

    private submitForm() {
        let form = document.getElementById('edit-form') as HTMLFormElement;
        form.submit();
    }

    private async validatePost(post: BlogPost) {
        try {
            await validateOrReject(post);
            this.submitForm();
        } catch (errors) {
            console.error(errors);
            this.handleInvalidPost(errors);
        }
    }

    private handleInvalidPost(errors: any) {
        // the code expects one specific error in this case
        const errorContainer = $('#blog-title-error');
        errorContainer.text(errors[0].constraints.length);
        errorContainer.removeClass('hide-tag');
    }

    setEditorContent(content: string) {
        this.qEditor.root.innerHTML = content;
    }
}
