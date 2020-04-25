<?php

namespace Tests\Unit\ModelTests;

use App\User;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class UserTest extends TestCase {

    protected $user;

    private const REMEMBER_TOKEN
        = 'p4M7RvuGe8diNfLgcSCPeVw3hNV5CYrfvkURfKHxj4ZvuNUMpXngRnigNzY3FMAiVrS5EyGqyDTPHaDXCnRERb4NBBuy7aEdD5wF';

    protected function setUp(): void {
        parent::setUp();
        $this->user = Mockery::mock(User::class)->makePartial();
        $this->user->name = 'test name';
        $this->user->email = 'unique@test.com';
        // todo email_verified_at uses a database connection internally, therefore I need a strategy for mocking it
        //$this->user->email_verified_at = time();
        $this->user->password = 'secret';
        $this->user->remember_token = self::REMEMBER_TOKEN;
    }

    public function testUserShouldNotBeNull() {
        self::assertNotNull($this->user);
    }

    public function testUserShouldHaveProperInstance() {
        self::assertInstanceOf(User::class, $this->user);
    }

    public function testUserNameShouldNotMatch() {
        self::assertNotEquals('wrong username', $this->user->name);
    }

    public function testUserNameShouldMatch() {
        self::assertEquals('test name', $this->user->name);
    }

    public function testUserEmailShouldNotMatch() {
        self::assertNotEquals('wrong@test.com', $this->user->email);
    }

    public function testUserEmailShouldMatch() {
        self::assertEquals('unique@test.com', $this->user->email);
    }

    // test disabled
    public function UserEmailVerifiedAtShouldNotBeLaterThanNow(){
        assertFalse($this->user->email_verified_at > time());
    }

    // test disabled
    public function UserEmailVerifiedAtShouldBeEarlierThanNow() {
        assertTrue($this->user->email_verified_at <= time());
    }

    public function testUserPasswordShouldNotMatch() {
        self::assertNotEquals('secret', $this->user->password);
    }

    public function testUserPasswordShouldMatch() {
        self::assertTrue(Hash::check('secret', $this->user->password));
    }

    public function testUserRememberTokenShouldNotMatch() {
        self::assertNotEquals('wrong token', $this->user->remember_token);
    }

    public function testUserRememberTokenShouldMatch() {
        self::assertEquals(self::REMEMBER_TOKEN, $this->user->remember_token);
    }

    public function testUserSaveFunctionShouldReturnFalse() {
        $this->user->shouldReceive('save')->andReturn(false);
        $assertValue = $this->user->save();
        self::assertFalse($assertValue);
    }

    public function testUserSaveFunctionShouldReturnTrue() {
        $this->user->shouldReceive('save')->andReturn(true);
        $assertValue = $this->user->save();
        self::assertTrue($assertValue);
    }

    public function testUserConstructorShouldConvertArrayToValidModel() {
        $userInput = [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password' => $this->user->password,
            'password_confirmation' => 'random'
        ];
        $user = new User($userInput);
        self::assertEquals($userInput['name'], $user->name);
    }

    protected function tearDown(): void {
        parent::tearDown();
        Mockery::close();
    }
}
