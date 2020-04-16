<?php

namespace Tests\Unit\ModelTests;

use App\User;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    protected $user;

    private const REMEMBER_TOKEN
        = 'p4M7RvuGe8diNfLgcSCPeVw3hNV5CYrfvkURfKHxj4ZvuNUMpXngRnigNzY3FMAiVrS5EyGqyDTPHaDXCnRERb4NBBuy7aEdD5wF';

    protected function setUp(): void {
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
    public function testUserEmailVerifiedAtShouldBeEarlierThanNow() {
        self::assertTrue($this->user->email_verified_at <= time());
    }

    public function testUserPasswordShouldNotMatch() {
        self::assertNotEquals('wrong password', $this->user->password);
    }

    public function testUserPasswordShouldMatch() {
        self::assertEquals('secret', $this->user->password);
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

    protected function tearDown(): void {
        Mockery::close();
    }
}
