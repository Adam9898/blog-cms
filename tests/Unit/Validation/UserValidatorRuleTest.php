<?php

namespace Tests\Unit\Validation;

use App\Validation\UserValidatorRule;
use App\Validation\ValidationRule;
use PHPUnit\Framework\TestCase;

class UserValidatorRuleTest extends TestCase {

    public function testUserValidatorRuleShouldImplementValidationRule() {
        $interfaces = class_implements(UserValidatorRule::class);
        self::assertEquals(ValidationRule::class, array_key_first($interfaces));
    }

    public function testGetValidationRulesShouldReturnAnArray() {
        self::assertIsArray(UserValidatorRule::getValidationRules());
    }

    // TODO test that getValidationRules return value contains all the fields that should be validated

}
