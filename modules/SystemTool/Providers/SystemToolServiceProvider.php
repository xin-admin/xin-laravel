<?php

namespace Modules\SystemTool\Providers;

use Laravel\Boost\Boost;
use Illuminate\Support\ServiceProvider;
use Modules\AnnoRoute\AnnoRoute;
use Modules\SystemTool\Ai\Boots\Reasonix;
use Modules\SystemTool\Services\SysSiteConfigService;

class SystemToolServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SysSiteConfigService::class, SysSiteConfigService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(AnnoRoute $annoRoute): void
    {
        Boost::registerAgent('reasonix', Reasonix::class);

        // 注册路由
        $annoRoute->register(base_path('modules/SystemTool/Http/Controllers'));
    }
}
