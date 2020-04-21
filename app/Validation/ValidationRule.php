<?php


namespace App\Validation;


interface ValidationRule {
    public static function getValidationRules(): array;
}
