<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use App\Policies\UserPolicy;
use App\Policies\BookPolicy;
use App\Policies\PublisherPolicy;
use App\Policies\AuthorPolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Book::class, BookPolicy::class);
        Gate::policy(Author::class, AuthorPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Publisher::class, PublisherPolicy::class);
    }
}
