<?php 

namespace Quill\ImageLibrary\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Quill\ImageLibrary\Models\ImageLibrary;

class ImageLibrarySaving
{
    // use Dispatchable, InteractsWithSockets, 
    use SerializesModels;
 
    public $data;

    /**
     * Create a new event instance.
     *
     * @param  \Quill\ImageLibrary\Models\ImageLibrary  $data
     * @return void
     */
    public function __construct(ImageLibrary $data) 
    {
        $this->data = $data;  
    }
}
