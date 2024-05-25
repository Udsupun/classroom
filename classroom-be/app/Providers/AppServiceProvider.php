<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

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
        });

        Gate::define('is-student', function (User $user) {
            return $user->role === 'student';
        });
    }
}
