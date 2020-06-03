import $ from 'jquery';
import {RegisterUser} from "../models/RegisterUser";
import {validateOrReject} from "class-validator";

export class Registration {

    private readonly INPUT_LISTENER_EVENT_NAME = 'keydown';
    private registerUser = new RegisterUser('', '', '', '');

    constructor() {
        this.activateEventListeners();
    }

    activateEventListeners() {
        console.log('activating event listeners')
        this.onNameInput();
        this.onEmailInput();
        this.onPasswordInput();
        this.onConfirmPasswordInput();
    }

    private onNameInput() {
        console.log('activating name input keydown listener');
        $('#name').on(this.INPUT_LISTENER_EVENT_NAME, (event) => {
            this.registerUser.name = (event.target as HTMLInputElement).value;
            this.validateInput('#name');
            console.log('validating name input');
        });
    }

    private onEmailInput() {
        $('#email').on(this.INPUT_LISTENER_EVENT_NAME, (event) => {
            this.registerUser.email = (event.target as HTMLInputElement).value;
            this.validateInput('#email');
        });
    }

    private onPasswordInput() {
        $('#password').on(this.INPUT_LISTENER_EVENT_NAME, (event) => {
            this.registerUser.password = (event.target as HTMLInputElement).value;
            this.validateInput('#password');
        });
    }


    private onConfirmPasswordInput() {
        $('#password-confirm').on(this.INPUT_LISTENER_EVENT_NAME, (event) => {
            this.registerUser.confirmPassword = (event.target as HTMLInputElement).value;
            this.validateInput('#password-confirm');
        });
    }

    /**
     * Validating an individual input and displaying the proper error message to the user
     */
    private async validateInput(inputID: string) {
        try {
            await validateOrReject(this.registerUser)
            $(inputID + '-error').addClass('hide-error');
            console.log('valid input');
        } catch (errors) {
            console.log('invalid input');
            console.log('error bag length: ' + errors.length);
            for (let i = 0; i < errors.length; i++) {
                console.log(errors[i]);
                if (errors[i].property === inputID) {
                    // getting the most relevant error message from the constraint obj
                    const  errorMessage = errors[i].constraints[Object.keys(errors[i].constraint)[0]];
                    $(inputID + '-error').val(errorMessage);
                    $(inputID + '-error').removeClass('hide-error');
                }
            }
        }
    }

}
