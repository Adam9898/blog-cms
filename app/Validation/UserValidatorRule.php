<?php


namespace App\Validation;


class UserValidatorRule implements ValidationRule {

    public static function getValidationRules(): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
    }

}
