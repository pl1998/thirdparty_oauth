<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 10:24.
 */

namespace Pl1998\ThirdpartyOauth;

/**
 * 支持 laravel 服务注入
 * Class ServiceProvider.
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(SocialiteAuth::class, function () {
            return new SocialiteAuth(config('services.aouth'));
        });

        $this->app->alias(SocialiteAuth::class, 'socialiteAuth');
    }

    public function provides()
    {
        return [SocialiteAuth::class, 'socialiteAuth'];
    }
}
