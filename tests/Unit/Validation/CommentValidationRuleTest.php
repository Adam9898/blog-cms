<?php

namespace Tests\Unit\Validation;

use App\Validation\CommentValidationRule;
use App\Validation\ValidationRule;
use PHPUnit\Framework\TestCase;

class CommentValidationRuleTest extends TestCase {

    public function testCommentValidatorRuleShouldImplementValidationRule() {
        $interfaces = class_implements(CommentValidationRule::class);
        self::assertEquals(ValidationRule::class, array_key_first($interfaces));
    }

    public function testGetValidationRulesShouldReturnAnArray() {
        self::assertIsArray(CommentValidationRule::getValidationRules());
    }

    public function testGetValidationRulesShouldReturnArrayWithProperKeys() {
        self::assertArrayHasKey('content', CommentValidationRule::getValidationRules());
        self::assertArrayHasKey('blog', CommentValidationRule::getValidationRules());
    }

}
