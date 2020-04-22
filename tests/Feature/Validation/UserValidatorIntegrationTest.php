<?php

namespace Tests\Feature\Validation;

use App\Validation\UserValidatorRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UserValidatorIntegrationTest extends TestCase {

    use RefreshDatabase;

    private $validator;

    protected function setUp(): void {
        parent::setUp();
        $dataToValidate = [
            'name' => 'testname',
            'email' => 'test@test.com',
            'password' => 'secrettesT88',
            'password_confirmation' => 'secrettesT88'
        ];
        $rules = UserValidatorRule::getValidationRules();
        $this->validator = Validator::make($dataToValidate, $rules);
    }

    public function testValidationShouldFailBecauseNameIsIncorrect() {
        $data = [
            'name' => 'hr',
            'email' => 'test@test.com',
            'password' => 'secrettesT88',
            'password_confirmation' => 'secrettesT88'
        ];
        $validator = Validator::make($data, UserValidatorRule::getValidationRules());
        self::assertTrue($validator->fails());
    }

    public function testValidationShouldPass() {
        self::assertFalse($this->validator->fails());
    }
}
