<?php

namespace Bluex\Fcm\Providers;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class FcmServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(ChannelManager $channelManager)
    {
        $channelManager->extend('firebase', function (Application $app, array $config) {
            return $app->make(FirebaseChannel::class);
        });
    }

    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__. '/../Config/fcm.php' => config_path('fcm.php'),
        ]);
    }
}
