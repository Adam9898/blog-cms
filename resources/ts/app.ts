import $ from 'jquery';
import {EditOrUpdatePost} from "./page-controller/EditOrUpdatePost";
import {Registration} from "./page-controller/Registration";
import {NotificationInit} from "./notifications/NotificationInit";

class App {

    editOrUpdate: EditOrUpdatePost | null = null;
    registration: Registration | null = null;
    notifications: NotificationInit | null = null;

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
    }

    private htmlElementExists(elementQuerySelector: string) {
        return $(elementQuerySelector).length !== 0;
    }

}


(window as any).app = new App();
