import {Sender} from "./Sender";
import {SenderHelper} from "./SenderHelper";
import $ from "jquery";

export class CommentSender implements Sender{

    private readonly FETCH_URL = '/comments';

    constructor(private comment: HTMLFormElement) {
        this.activateEventListeners();
    }

    private activateEventListeners() {
        $(`#${this.comment.id}`).on('submit', (event) => {
            event.preventDefault();
            this.send();
        })
    }

    /**
     * Post and display comment the the server. You can specify the comment as an argument or the algorithm will
     * reference the class property.
    */
    send(sendForm: HTMLFormElement = this.comment): void {
        this.postComment(sendForm).then(() => {
            this.displayComment(sendForm);
            this.emptyFormContent();
            this.moveToComment();
        });
    }

    private async postComment(comment: HTMLFormElement) {
       try {
           const loadingContainer = document.querySelector('#new-comment .sender-loading-animation') as HTMLElement;
           SenderHelper.displayLoadingAnimation(loadingContainer);
           await fetch(this.FETCH_URL, {
               method: 'POST',
               body: new FormData(comment),
               credentials: 'include'
           });
           SenderHelper.removeLoadingAnimation();
       } catch (e) {
           console.error('problem sending comment to server', e);
       }

    }

    private displayComment(commentForm: HTMLFormElement) {
        const content = $('textarea', commentForm).val() as string;
        const commentTemplate = document.querySelector('#comments template') as HTMLTemplateElement;
        const commentNode = commentTemplate.content.cloneNode(true);
        $('.comment-content', commentNode).text(content);
        document.getElementById('comments')!.prepend(commentNode);
    }

    private emptyFormContent() {
        $('textarea', this.comment).text('').val('');
    }

    private moveToComment() {
        $('#comments .comment:first-child').get(0).scrollIntoView();
    }
}

