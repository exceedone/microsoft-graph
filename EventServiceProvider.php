<?php

namespace ExmentOauth\MicrosoftGraph;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            '\ExmentOauth\MicrosoftGraph\GraphExtendSocialite@handle',
        ],
    ];
}
