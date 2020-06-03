import {ValidationArguments, ValidatorConstraint, ValidatorConstraintInterface} from 'class-validator';
import {UniqueEmailJSONFormat} from "./UniqueEmailJSONFormat";

@ValidatorConstraint({async: true})
export class IsEmailAlreadyExistsConstraint implements ValidatorConstraintInterface {
    async validate(email: string, validationArguments?: ValidationArguments) {
        let response = await fetch(`/api/uniqueEmail/${email}`);
        let jsonResult: UniqueEmailJSONFormat = await response.json();
        return jsonResult.valid;
    }
}
