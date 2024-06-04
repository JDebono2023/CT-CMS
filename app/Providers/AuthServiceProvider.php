<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\media;
use App\Models\device;
use App\Models\category;
use App\Policies\TeamPolicy;
use App\Policies\MediaPolicy;
use App\Policies\DevicePolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        category::class => CategoryPolicy::class,
        media::class => MediaPolicy::class,
        device::class => DevicePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
