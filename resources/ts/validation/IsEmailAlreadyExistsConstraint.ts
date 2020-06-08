import {ValidationArguments, ValidatorConstraint, ValidatorConstraintInterface} from 'class-validator';
import {UniqueEmailJSONFormat} from "./UniqueEmailJSONFormat";

@ValidatorConstraint({async: true})
export class IsEmailAlreadyExistsConstraint implements ValidatorConstraintInterface {
    async validate(email: string, validationArguments?: ValidationArguments) {
        if (email.length < 1) { // resolving 404 issue if email is empty
            return false;
        }
        let response = await fetch(`api/unique-email/${email}`);
        let jsonResult: UniqueEmailJSONFormat = await response.json();
        return jsonResult.valid;
    }
}
