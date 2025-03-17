<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Define Gates for campaign management
        Gate::define('create-campaign', fn($user) => $user->hasRole(['فرقة تطوعية', 'منظمة']));
        Gate::define('edit-campaign', fn($user) => $user->hasRole(['فرقة تطوعية', 'منظمة']));
        Gate::define('delete-campaign', fn($user) => $user->hasRole(['فرقة تطوعية', 'منظمة']));
        Gate::define('view-campaigns', fn($user) => $user->hasAnyRole(['مستخدم', 'فرقة تطوعية', 'منظمة']));
        Gate::define('join-campaign', fn($user) => $user->hasAnyRole(['مستخدم', 'فرقة تطوعية', 'منظمة']));
        Gate::define('manage-volunteers', fn($user) => $user->hasRole(['فرقة تطوعية', 'منظمة']));
        Gate::define('view-reports', fn($user) => $user->hasRole('منظمة'));
        
        // صلاحيات النشرة البريدية
        Gate::define('viewNewsletterSubscribers', fn($user) => $user->hasRole('مشرف'));
        Gate::define('deleteNewsletterSubscribers', fn($user) => $user->hasRole('مشرف'));
    }
}
