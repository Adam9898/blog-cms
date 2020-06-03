import { registerDecorator, ValidationOptions } from 'class-validator';
import {IsEmailAlreadyExistsConstraint} from "./IsEmailAlreadyExistsConstraint";


export function UniqueEmail(validationOptions?: ValidationOptions) {
    return (object: Object, propertyName: string) => {
        registerDecorator({
            target: object.constructor,
            propertyName: propertyName,
            options: validationOptions,
            constraints: [],
            validator: IsEmailAlreadyExistsConstraint
        });
    };
}
