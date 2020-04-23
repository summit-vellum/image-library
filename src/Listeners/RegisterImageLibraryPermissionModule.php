<?php

namespace Quill\ImageLibrary\Listeners;

class RegisterImageLibraryPermissionModule
{ 
    public function handle()
    {
        return [
            'ImageLibrary' => [
                'view'
            ]
        ];
    }
}
