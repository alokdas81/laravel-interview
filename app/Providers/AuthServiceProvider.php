<?php

namespace App\Providers;

use App\Domain\Blog\Infrastructures\Policies\CategoryPolicy;
use App\Domain\Blog\Entities\Category;

use App\Domain\Blog\Infrastructures\Policies\PostPolicy;
use App\Domain\Blog\Entities\Post;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
