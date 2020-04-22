<?php


namespace App\Validation;


class UserValidatorRule implements ValidationRule {

    public static function getValidationRules(): array {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6',
                'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)+.{6,50}$/']
        ];
    }

}
