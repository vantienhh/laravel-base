<?php

namespace App\Providers;

use App\Repositories\Contacts\ContactRepository;
use App\Repositories\Contacts\ContactRepositoryInterface;
use App\Repositories\Subscribers\SubscriberRepository;
use App\Repositories\Subscribers\SubscriberRepositoryInterface;
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
        $this->app->singleton(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->singleton(SubscriberRepositoryInterface::class, SubscriberRepository::class);
    }
}
