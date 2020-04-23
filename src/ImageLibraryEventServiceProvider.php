<?php

namespace Quill\ImageLibrary;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ImageLibraryEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
       
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'Quill\ImageLibrary\Listeners\ImageLibraryEventSubscriber',
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
