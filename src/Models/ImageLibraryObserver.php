<?php

namespace Quill\ImageLibrary\Models;

use Illuminate\Support\Str;
use Quill\ImageLibrary\Events\ImageLibraryCreating;
use Quill\ImageLibrary\Events\ImageLibraryCreated;
use Quill\ImageLibrary\Events\ImageLibrarySaving;
use Quill\ImageLibrary\Events\ImageLibrarySaved;
use Quill\ImageLibrary\Events\ImageLibraryUpdating;
use Quill\ImageLibrary\Events\ImageLibraryUpdated;
use Quill\ImageLibrary\Models\ImageLibrary;

class ImageLibraryObserver
{

    public function creating(ImageLibrary $imagelibrary)
    {
        // creating logic... 
        event(new ImageLibraryCreating($imagelibrary));
    }

    public function created(ImageLibrary $imagelibrary)
    {
        // created logic...
        event(new ImageLibraryCreated($imagelibrary));
    }

    public function saving(ImageLibrary $imagelibrary)
    {
        // saving logic...
        event(new ImageLibrarySaving($imagelibrary));
    }

    public function saved(ImageLibrary $imagelibrary)
    {
        // saved logic...
        event(new ImageLibrarySaved($imagelibrary));
    }

    public function updating(ImageLibrary $imagelibrary)
    {
        // updating logic...
        event(new ImageLibraryUpdating($imagelibrary));
    }

    public function updated(ImageLibrary $imagelibrary)
    {
        // updated logic...
        event(new ImageLibraryUpdated($imagelibrary));
    }

}