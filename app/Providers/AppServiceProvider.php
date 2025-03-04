<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Strict Mode 개발 환경에서만 사용 || 상용 환경에서는 사용 안 함
        // 1. Eager Loading 활성화
        // 2. fillable guarded 에러 활성화
        // 3. 불필요한 데이터 접근 시 에러 활성화
        Model::shouldBeStrict(! $this->app->isProduction());
    }
}
