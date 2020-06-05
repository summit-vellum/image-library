<?php

namespace Quill\ImageLibrary;

use Vellum\Module\Quill;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Quill\ImageLibrary\Listeners\RegisterImageLibraryModule;
use Quill\ImageLibrary\Listeners\RegisterImageLibraryPermissionModule;
use Quill\ImageLibrary\Resource\ImageLibraryResource;
use App\Resource\ImageLibrary\ImageLibraryRootResource;
use Quill\ImageLibrary\Models\ImageLibraryObserver;

class ImageLibraryServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadModuleCommands();
        $this->loadRoutesFrom(__DIR__ . '/routes/imagelibrary.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'image-library');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/imagelibrary.php', 'imagelibrary');

        ImageLibraryResource::observe(ImageLibraryObserver::class);

        if (class_exists('App\Resource\ImageLibrary\ImageLibraryRootResource')) {
        	ImageLibraryRootResource::observe(ImageLibraryObserver::class);
        }

        $this->publishes([
            __DIR__ . '/config/imagelibrary.php' => config_path('imagelibrary.php'),
        ], 'imagelibrary.config');

        // $this->publishes([
        //    __DIR__ . '/views' => resource_path('/vendor/imagelibrary'),
        // ], 'imagelibrary.views');

        $this->publishes([
        	__DIR__ . '/public/css/dropzone' => public_path('vendor/imagelibrary/css/dropzone'),
        ], 'dropzone.css');

        $this->publishes([
        	__DIR__ . '/public/css/cropper.css' => public_path('vendor/imagelibrary/css/cropper.css'),
        ], 'cropper.css');

        $this->publishes([
        	__DIR__ . '/public/css/image-multiple-upload.css' => public_path('vendor/imagelibrary/css/image-multiple-upload.css'),
        ], 'image-multiple-upload.css');

        $this->publishes([
        	__DIR__ . '/public/js/dropzone' => public_path('vendor/imagelibrary/js/dropzone'),
        ], 'dropzone.js');

        $this->publishes([
        	__DIR__ . '/public/js/jquery-cropper' => public_path('vendor/imagelibrary/js/jquery-cropper'),
        ], 'cropper.js');

        $this->publishes([
        	__DIR__ . '/public/js/imagelibrary.js' => public_path('vendor/imagelibrary/js/imagelibrary.js'),
        ], 'imagelibrary.js');

        $this->publishes([
        	__DIR__ . '/database/factories/ImageLibraryFactory.php' => database_path('factories/ImageLibraryFactory.php'),
            __DIR__ . '/database/seeds/ImageLibraryTableSeeder.php' => database_path('seeds/ImageLibraryTableSeeder.php'),
        ], 'imagelibrary.migration');
    }

    public function register()
    {
        Event::listen(Quill::MODULE, RegisterImageLibraryModule::class);
        Event::listen(Quill::PERMISSION, RegisterImageLibraryPermissionModule::class);
    }

    public function loadModuleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([

            ]);
        }
    }
}
