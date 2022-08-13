<?php

namespace App\Providers;

use App\Repository\Category\CategoryInterface;
use App\Repository\Category\CategoryRepository;
use App\Repository\Tag\TagInterface;
use App\Repository\Tag\TagRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TagInterface::class, TagRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
