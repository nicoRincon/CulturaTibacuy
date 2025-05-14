<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Illuminate\Session\SessionManager;
use App\Extensions\CustomDatabaseSessionHandler;
use App\Models\PersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        
        $this->app->resolving(SessionManager::class, function ($manager) {
            $manager->extend('database', function ($app) {
                $connection = $app['config']['session.connection'];
                $table = $app['config']['session.table'];
                $lifetime = $app['config']['session.lifetime'];
                $lottery = $app['config']['session.lottery'];
                
                return new CustomDatabaseSessionHandler(
                    $app['db']->connection($connection),
                    $table,
                    $lifetime,
                    $app,
                    $lottery
                );
            });
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}