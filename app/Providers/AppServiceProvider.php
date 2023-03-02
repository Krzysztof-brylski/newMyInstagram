<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Likes;
use App\Models\Post;
use App\Observers\CommentsObserver;
use App\Observers\LikesObserver;
use App\Observers\PostObserver;
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
        Comment::observe(CommentsObserver::class);
        Post::observe(PostObserver::class);
        Likes::observe(LikesObserver::class);
    }
}
