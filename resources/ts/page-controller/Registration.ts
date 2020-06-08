import $ from 'jquery';
import {RegisterUser} from "../models/RegisterUser";
import {equals, validate, validateOrReject, ValidationError, Validator} from "class-validator";

export class Registration {

    private readonly INPUT_LISTENER_EVENT_NAME = 'keyup';
    private registerUser = new RegisterUser('', '', '', '');

    constructor() {
        this.activateEventListeners();
    }

    activateEventListeners() {
        this.onInput('#name', 'name');
        this.onInput('#email', 'email');
        this.onInput('#password', 'password');
        this.onInput('#password-confirm', 'confirmPassword');
        this.onSubmit('#register-form');
    }

    private onInput(inputID: string, inputPropertyName: string) {
        $(inputID).on(this.INPUT_LISTENER_EVENT_NAME, (event) => {
            (this.registerUser as { [index: string]: any })[inputPropertyName] = (event.target as HTMLInputElement).value;
            this.validateInput(inputID);
        });
    }

    private onSubmit(formID: string) {
        $(formID).on('submit', (event) => {
           event.preventDefault();
            validate(this.registerUser).then(validationErrors => {
                if (validationErrors.length > 0) {
                    $(formID).filter(':input').each((index, element) => {
                        this.validateInput(element.id);
                    });
                } else {
                    let form = document.getElementById(formID.substr(1)) as HTMLFormElement;
                    form.submit();
                }
            });
        });
    }


    /**
     * Validating an individual input and displaying the proper error message to the user
     */
    private validateInput(inputID: string) {
        validate(this.registerUser).then(validationErrors => {
            if (this.isValid(validationErrors, inputID.substr(1))) {
                $(inputID + '-error').addClass('hide-tag').text('');
            } else {
                for (let i = 0; i < validationErrors.length; i++) {
                    const constraints = validationErrors[i].constraints;
                    const inputName = inputID.substr(1);
                    // && constraints null and undefined type guard
                    if (this.scramble(inputName, validationErrors[i].property) && constraints != null) {
                        // getting the most relevant error message from the constraints obj
                        const errorMessage = constraints[Object.keys(constraints)[0]];
                        $(inputID + '-error').text(errorMessage);
                        $(inputID + '-error').removeClass('hide-tag');
                    }
                }
            }
        }).catch(errors => {
            console.log('something went wrong when validating input', errors);
        });
    }

    private isValid(validationErrors: ValidationError[], prop: string) {
        let valid = true;
        let i = 0;
        while (valid && i < validationErrors.length) {
            if (this.scramble(prop, validationErrors[i].property)) valid = false;
            i++;
        }
        return valid;
    }

    /**
     * Check if a string contains every characters of another string. The algorithm is case insensitive
     */
    private scramble(string1: string, string2: string) {
        string1 = string1.toLocaleLowerCase();
        string2 = string2.toLocaleLowerCase();
        return string2.split('').every(function(character) {
            // Every string2 characters must be included in the string1
            return string1.includes(character);
        });
    }
}
