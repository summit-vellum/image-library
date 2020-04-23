<?php

namespace Quill\ImageLibrary\Models\Gates;

class ImageLibraryGate
{
    protected $module;
    protected $user;
    protected $policies;

    public function __construct()
    {
        $this->module = 'image-library';
        $this->user = auth()->user();
        $this->policies = $this->user->policies()[$this->module];
    } 

    public function view()
    {
        if (in_array(__FUNCTION__, $this->policies) || in_array("*", $this->policies)) {

            return true;
        }

        return false;
    }
    
}
