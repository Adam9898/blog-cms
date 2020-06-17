import $ from 'jquery';
import {EditOrUpdatePost} from "./page-controller/EditOrUpdatePost";
import {Registration} from "./page-controller/Registration";
import {NotificationInit} from "./notifications/NotificationInit";
import {CommentSender} from "./comments/CommentSender";
import {BlogTimeZoneConverter} from "./timezone/BlogTimeZoneConverter";

class App {

    editOrUpdate: EditOrUpdatePost | null = null;
    registration: Registration | null = null;
    notifications: NotificationInit | null = null;
    comments: CommentSender | null = null;
    timeZoneConverter: BlogTimeZoneConverter | null = null;

    constructor() {
        this.initializeScripts();
    }

    private initializeScripts() {
        if (this.htmlElementExists('#editor')) {
            this.editOrUpdate = new EditOrUpdatePost();
        } else if (this.htmlElementExists('#register-form')) {
            this.registration = new Registration();
        }
        this.notifications = new NotificationInit();
        if (this.htmlElementExists('#new-comment')) {
            const newCommentForm = document.getElementById('new-comment') as HTMLFormElement;
            this.comments = new CommentSender(newCommentForm);
        }
        if (this.htmlElementExists('#post-date-meta')) {
            const dateElement = document.querySelector('#post-date-meta i')! as HTMLElement;
            this.timeZoneConverter = new BlogTimeZoneConverter(dateElement);
        }
    }

    private htmlElementExists(elementQuerySelector: string) {
        return $(elementQuerySelector).length !== 0;
    }

}


(window as any).app = new App();
