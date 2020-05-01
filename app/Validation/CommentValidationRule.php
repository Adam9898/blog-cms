<?php


namespace App\Validation;


class CommentValidationRule implements ValidationRule {

    public static function getValidationRules(): array {
        return [
            'content' => ['required', 'string', 'min:3', 'max:500'],
            'blog' => ['required', 'integer', 'min:1']
        ];
    }
}
