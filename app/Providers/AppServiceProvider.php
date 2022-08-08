<?php

namespace App\Providers;

use App\Billing\BankPaymentGateway;
use App\Billing\CreditPaymentGateway;
use App\Billing\PaymentGatewayContract;
use App\Repository\Tag\TagInterface;
use App\Repository\Tag\TagRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(BankPaymentGateway::class, function($app){
        //     return new BankPaymentGateway('euro');
        // });
        $this->app->singleton(PaymentGatewayContract::class, function ($app) {

            if(request()->has('credit')){
                return new CreditPaymentGateway('euro');
            }
            return new BankPaymentGateway('euro'); 
        });

        $this->app->bind(TagInterface::class, TagRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
