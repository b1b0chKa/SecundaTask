<?php

namespace App\Providers;

use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Response;
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
        Response::macro('api', function ($code, $data = null, ?string $message = null)
        {
            return ApiResponse::success($data, $message, $code);
        });
    }
}
