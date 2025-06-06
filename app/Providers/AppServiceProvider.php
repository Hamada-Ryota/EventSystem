<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\EventReview;
use App\Policies\EventReviewPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        EventReview::class => EventReviewPolicy::class,
    ];
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
        Gate::define('admin', function ($user) {
            return $user->role_id === 3; // role_idが3なら管理者
        });

    }
}
