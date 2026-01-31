<?php

namespace App\Providers;

use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class => TaskPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Task::class, TaskPolicy::class);
        
        Password::defaults(function () {
            return Password::min(8);
        });
    }
}
