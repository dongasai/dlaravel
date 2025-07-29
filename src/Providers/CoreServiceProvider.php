<?php

namespace DLaravel\Providers;

use Illuminate\Support\ServiceProvider;
use DLaravel\Contracts\LogInterface;
use DLaravel\Contracts\EventInterface;
use DLaravel\Contracts\CacheInterface;
use DLaravel\Contracts\ConfigInterface;
use DLaravel\Contracts\ValidationInterface;
use DLaravel\Services\LogService;
use DLaravel\Services\EventService;
use DLaravel\Services\CacheService;
use DLaravel\Services\ConfigService;
use DLaravel\Services\ValidationService;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * 注册服务
     */
    public function register(): void
    {
        // 注册核心服务接口绑定
        $this->registerCoreServices();

        // 注册配置
        $this->registerConfig();
    }

    /**
     * 启动服务
     */
    public function boot(): void
    {
        // 注册中间件
        $this->registerMiddleware();

        // 加载路由
        $this->loadRoutes();

        // 发布配置
        $this->publishConfig();
    }

    /**
     * 注册核心服务
     */
    protected function registerCoreServices(): void
    {
        // 注册日志服务
        $this->app->singleton(LogInterface::class, LogService::class);

        // 注册事件服务
        $this->app->singleton(EventInterface::class, EventService::class);

        // 注册缓存服务
        $this->app->singleton(CacheInterface::class, CacheService::class);

        // 注册配置服务
        $this->app->singleton(ConfigInterface::class, ConfigService::class);

        // 注册验证服务
        $this->app->singleton(ValidationInterface::class, ValidationService::class);
    }

    /**
     * 注册配置
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/core.php',
            'core'
        );
    }

    /**
     * 注册中间件
     */
    protected function registerMiddleware(): void
    {
        $router = $this->app['router'];

        // 注册全局中间件
        $router->aliasMiddleware('log.request', \DLaravel\Middleware\LogRequestMiddleware::class);
        $router->aliasMiddleware('validate.request', \DLaravel\Middleware\ValidateRequestMiddleware::class);
    }

    /**
     * 加载路由
     */
    protected function loadRoutes(): void
    {
        // $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    /**
     * 发布配置
     */
    protected function publishConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../Config/core.php' => config_path('core.php'),
        ], 'core-config');
    }
}