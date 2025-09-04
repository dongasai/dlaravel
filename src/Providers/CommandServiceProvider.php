<?php

namespace DLaravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schedule;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 注册DLaravel命令
        $this->commands([
            \DLaravel\Commands\GenerateModelAnnotation::class,
            \DLaravel\Commands\GenerateAppTreeCommand::class,
            \DLaravel\Commands\CleanSizeRotatingLogsCommand::class,

            \DLaravel\Commands\ExampleCommand::class
        ]);

        // 注册DLaravel定时任务
        $this->registerSchedules();
    }

    public function register()
    {
        //
    }

    /**
     * 注册DLaravel相关的定时任务
     *
     * 将原本在 routes/console.php 中的DLaravel调度配置迁移到此处
     */
    protected function registerSchedules(): void
    {
        // 在应用完全启动后注册定时任务
        $this->app->booted(function () {
            // 每天凌晨3点清理 size_rotating_daily 日志文件（保留配置的天数）
            Schedule::command('ucore:clean-size-rotating-logs')
                ->dailyAt('03:00')
                ->description('清理DLaravel轮转日志文件');
        });
    }
}
