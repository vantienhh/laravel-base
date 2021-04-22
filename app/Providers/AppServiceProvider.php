<?php

namespace App\Providers;

use App\Repositories\Contacts\ContactRepository;
use App\Contracts\Contact\ContactRepositoryInterface;
use App\Repositories\Subscribers\SubscriberRepository;
use App\Contracts\Subscriber\SubscriberRepositoryInterface;
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
