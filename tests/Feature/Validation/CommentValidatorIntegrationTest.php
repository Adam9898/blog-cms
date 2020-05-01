<?php

namespace Tests\Feature;

use App\Validation\CommentValidationRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
Use Illuminate\Validation\Validator as RealValidator;
use Tests\TestCase;

class CommentValidatorIntegrationTest extends TestCase {

    use RefreshDatabase;

    private $validator;
    private $validCommentArr;

    protected function setUp(): void {
        parent::setUp();
        $this->validCommentArr = [
            'content' => 'This is a valid test comment',
            'blog' => 1
        ];
        $this->validator = Validator::make($this->validCommentArr, CommentValidationRule::getValidationRules());
    }

    public function testValidatorShouldNotBeNull() {
        self::assertNotNull($this->validator);
    }

    public function testValidatorShouldBeAnInstanceOfValidator() {
        self::assertInstanceOf(RealValidator::class, $this->validator);
    }

    public function testValidatorShouldPass() {
        self::assertFalse($this->validator->fails());
    }

    public function testValidatorShouldFailBecauseContentIsTooShort() {
        $this->validCommentArr['content'] = 'sh';
        $this->validator = Validator::make($this->validCommentArr, CommentValidationRule::getValidationRules());
        self::assertTrue($this->validator->fails());
    }

    public function testValidatorShouldFailBecauseBlogIdIsNotInteger() {
        $this->validCommentArr['blog'] = 'dsa';
        $this->validator = Validator::make($this->validCommentArr, CommentValidationRule::getValidationRules());
        self::assertTrue($this->validator->fails());
    }

}
