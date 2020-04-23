<?php

namespace Quill\ImageLibrary\Resource;

use Quill\Html\Fields\ID;
use Quill\ImageLibrary\Models\ImageLibrary;
use Vellum\Contracts\Formable;

class ImageLibraryResource extends ImageLibrary implements Formable
{
    public function fields()
    {
        return [
            ID::make()->sortable()->searchable(),
        ];
    }

    public function filters()
    {
        return [
            //
        ];
    }

    public function actions()
    {
        return [
            new \Vellum\Actions\EditAction,
            new \Vellum\Actions\ViewAction,
            new \Vellum\Actions\DeleteAction,
        ];
    }

    public function excludedFields()
    {
    	return [
    		//
    	];
    }
}
