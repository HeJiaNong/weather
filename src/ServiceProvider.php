<?php
/**
 * Created by PhpStorm.
 * User: jianong
 * Date: 2019-07-16
 * Time: 20:47
 */

namespace Hejiang\Weather;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Weather::class, function () {
            return new Weather(config('services.weather.key'));
        });

        $this->app->alias(Weather::class, 'weather');
    }

    public function provides()
    {
        return [Weather::class, 'weather'];
    }
}