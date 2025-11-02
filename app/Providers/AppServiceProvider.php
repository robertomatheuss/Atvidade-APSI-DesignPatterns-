<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LogServiceSingleton;

use App\Services\PaymentAdapter\LegacyPaymentProcessor;
use App\Services\PaymentAdapter\NewPaymentSystem;
use App\Services\PaymentAdapter\Adapter\NewPaymentAdapter;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton(LogServiceSingleton::class, function () {
            return new LogServiceSingleton();
        });
        
        // Sempre que alguém pedir LegacyPaymentProcessor, devolva o Adapter,
        // que por baixo usa o NewPaymentSystem.
        $this->app->bind(LegacyPaymentProcessor::class, function ($app) {
        return new NewPaymentAdapter(new NewPaymentSystem());
    });
    }

    public function boot(): void{}
}
