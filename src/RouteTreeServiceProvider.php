<?php
/**
 * Created by PhpStorm.
 * User: GeraldB
 * Date: 16.03.2016
 * Time: 11:51
 */

namespace Nicat\RouteTree;

use Illuminate\Support\ServiceProvider;
use Nicat\RouteTree\Middleware\PushLocalToSession;

class RouteTreeServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        // Publish the config.
        $this->publishes([
            __DIR__.'/config/routetree.php' => config_path('routetree.php'),
        ]);

        // Load default translations.
        $this->loadTranslationsFrom(__DIR__ . "/resources/lang","Nicat-RouteTree");

        // Register the RouteTreeMiddleware.
        $this->app['Illuminate\Contracts\Http\Kernel']->pushMiddleware(RouteTreeMiddleware::class);

        if($this->app['router']->hasMiddlewareGroup('web')) {
            $this->app['router']->pushMiddlewareToGroup('web', PushLocalToSession::class);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        // Merge the config.
        $this->mergeConfigFrom(__DIR__.'/config/routetree.php', 'routetree');

        // Register the RouteTree singleton.
        $this->app->singleton(RouteTree::class, function()
        {
            return new RouteTree();
        });

    }

}