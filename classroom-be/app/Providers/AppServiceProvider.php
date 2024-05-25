<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('is-teacher', function (User $user) {
            return $user->role === 'teacher';
        }, 'You are not authorized to access this.');

        Gate::define('is-student', function (User $user) {
            return $user->role === 'student';
        }, 'You are not authorized to access this.');
    }
}
