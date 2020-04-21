<?php

namespace Tests\Feature\RepositoryTests;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRepositoryDatabaseTest extends TestCase
{
    use RefreshDatabase;

    private static $userRepository;
    private $databaseData;
    private const TABLE_NAME = 'users';

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        self::$userRepository = resolve(UserRepository::class);
    }

    protected function setUp(): void {
        parent::setUp();
        $this->databaseData = factory(User::class)->make();
    }

    public function testUserRepositoryShouldNotBeNull() {
        self::assertNotNull(self::$userRepository);
    }

    public function testUserRepositoryShouldBeOfProperInstance() {
        self::assertInstanceOf(UserRepository::class, self::$userRepository);
    }

    public function testCreateNewUserInsertsANewUserToDatabaseShouldNotFindADifferentUser() {
        self::$userRepository->createNewUser($this->databaseData);
        $this->expectException(ModelNotFoundException::class);
        User::findOrFail($this->databaseData->id + 100)->get();
    }

    public function testCreateNewUserInsertsANewUserToDatabaseShouldActuallyHaveTheSameUser() {
        self::$userRepository->createNewUser($this->databaseData);
        $user = User::findOrFail($this->databaseData->id)->get();
        $user = $user[0];
        self::assertEquals($this->databaseData->content, $user->content);
    }

}
