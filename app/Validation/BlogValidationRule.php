<?php


namespace App\Validation;


class BlogValidationRule implements ValidationRule {

    public static function getValidationRules(): array {
        return [
            'title' => ['required', 'string', 'min:5', 'max:30'],
            'content' => ['required', 'string', 'min:100', 'max:5000']
        ];
    }
}
