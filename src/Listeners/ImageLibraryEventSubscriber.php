<?php

namespace Quill\ImageLibrary\Listeners;
use Illuminate\Support\Facades\Log;

class ImageLibraryEventSubscriber
{
    /**
     * Handle the event.
     */
    public function handleCreated($event) 
    {
        //
    } 

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Quill\ImageLibrary\Events\ImageLibraryCreated',
            'Quill\ImageLibrary\Listeners\ImageLibraryEventSubscriber@handleCreated'
        ); 
    }
}