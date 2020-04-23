<?php

use Illuminate\Database\Seeder;
use Quill\ImageLibrary\Models\ImageLibrary;

class ImageLibraryTableSeeder extends Seeder
{
   	/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ImageLibrary::class, 10)->create();
    }

}
