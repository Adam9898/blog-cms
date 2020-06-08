import {Validatable} from "../validation/Validatable";
import {Equals, IsEmail, Length, Matches, Max} from "class-validator";
import {UniqueEmail} from "../validation/UniqueEmail";
import {Match} from "../validation/match.decorator";

export class RegisterUser implements Validatable {

    @Length(3, 255, {
        message: 'Name should be a minimum of 3 and a maximum of 255 characters long'
    })
    name: string;

    @IsEmail({}, {
        message: 'This is not a valid email address'
    })
    @UniqueEmail({
        message: 'This email address is in use. Please choose a different one'
    })
    email: string;

    @Matches(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)+.{6,50}$/, {
        message: 'Password length should be between 6 and 50, and it should container a small case letter, an upper case letter, and a number'

    })
    password: string;

    @Match('password', {
        message: "Password doesn't match"
    })
    confirmPassword: string;

    constructor(name: string, email: string, password: string, confirmPassword: string) {
        this.name = name;
        this.email = email;
        this.password = password;
        this.confirmPassword = confirmPassword;
    }

}
