<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Cours;
use App\Policies\CoursPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Cours::class => CoursPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
