<?php
/**
 * HomePage: https://github.com/yocome
 * Created by Yong.
 * Date: 2016/1/21
 * Time: 16:07
 */

namespace Yocome\Cors;

use Illuminate\Support\ServiceProvider;

class CorsServiceProvider extends ServiceProvider
{
    /**
     * Register OPTIONS route to any requests
     */
    public function register()
    {

        $config = $this->app['config']['cors'];

        $this->app->bind('Yocome\Cors\CorsService', function() use ($config){
            return new CorsService($config);
        });

    }

}