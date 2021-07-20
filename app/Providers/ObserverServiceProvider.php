<?php

namespace App\Providers;

use App\Merchant;
use App\Observers\MerchantObserver;
use App\Observers\SubscriptionObserver;
use App\Observers\UserObserver;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Subscription;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Merchant::observe(MerchantObserver::class);
        Subscription::observe(SubscriptionObserver::class);
    }    
}
