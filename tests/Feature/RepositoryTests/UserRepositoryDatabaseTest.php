<?php

namespace Tests\Feature\RepositoryTests;

use App\Enums\UserRole;
use App\Repositories\UserRepository;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
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

    public function testGetUserRolesShouldReturnACollection() {
        $user = factory(User::class)->create();
        $collection = self::$userRepository->getUserRoles($user);
        self::assertInstanceOf(Collection::class, $collection);
    }

    public function testGetUserRolesShouldReturnProperRoles() {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $user->roles()->attach(1); // role id 1 is regular
        $collection = self::$userRepository->getUserRoles($user);
        // expected role is REGULAR because that is what the role factory generates
        self::assertEquals($role->role_name, $collection->find(1)->role_name);
    }

    public function testFindUserByEmailShouldReturnAUser() {
        $this->databaseData->save();
        $user = self::$userRepository->findUserByEmail($this->databaseData->email);
        self::assertInstanceOf(User::class, $user);
    }

    public function testFindUserByEmailShouldReturnTheProperUser() {
        $this->databaseData->save();
        $user = self::$userRepository->findUserByEmail($this->databaseData->email);
        self::assertEquals($this->databaseData->id, $user->id);
    }

}
