<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Thuoc;
use App\Policies\ThuocPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Thuoc::class => ThuocPolicy::class,
        // Register other policies here
    ];

    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
