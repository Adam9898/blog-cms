import {Validatable} from "../validation/Validatable";
import {IsEmail, Length, Matches, Max} from "class-validator";
import {UniqueEmail} from "../validation/UniqueEmail";

export class RegisterUser implements Validatable {

    @Length(3, 255, {
        message: 'Name should be a minimum of 3 and a maxmimum of 255 characters long'
    })
    name: string;

    @IsEmail({}, {
        message: 'Please provide a valid email address'
    })
    @Max(255)
    @UniqueEmail({
        message: 'This email address is in use. Please choose a diferent one'
    })
    email: string;

    @Matches(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)+.{6,50}$/, { // todo remove slash
        message: 'Password length should be between 6 and 50, and it should container a small case letter, an upper case letter, and a number'

    })
    password: string;

    confirmPassword: string;

    constructor(name: string, email: string, password: string, confirmPassword: string) {
        this.name = name;
        this.email = email;
        this.password = password;
        this.confirmPassword = confirmPassword;
    }

}
