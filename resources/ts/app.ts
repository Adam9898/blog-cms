import $ from 'jquery';
import {EditOrUpdatePost} from "./page-controller/EditOrUpdatePost";
import {Registration} from "./page-controller/Registration";

console.log("Typescript works");

class App {

    editOrUpdate: EditOrUpdatePost | null = null;
    registration: Registration | null = null;

    constructor() {
        this.initializeScripts();
    }

    private initializeScripts() {
        if (this.htmlElementExists('#editor')) {
            this.editOrUpdate = new EditOrUpdatePost();
        } else if (this.htmlElementExists('#register-form')) {
            this.registration = new Registration();
        }
    }

    private htmlElementExists(elementQuerySelector: string) {
        return $(elementQuerySelector).length !== 0;
    }

}

let app = new App();
