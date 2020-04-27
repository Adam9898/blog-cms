<?php

namespace App\Providers;

use App\Blog;
use App\Policies\BlogPolicy;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // auto-discover Blog::class => BlogPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->registerPolicies();

        Gate::define('role', function (User $user, $roleName) use ($userRepository, $roleRepository) {
            $roles = $userRepository->getUserRoles($user);
            $roleId = $roleRepository->getRoleIdByName($roleName);
            $roleFromCollection = $roles->find($roleId);
            return $roleFromCollection !== null;
        });
    }
}
