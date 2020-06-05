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
        $old_db = DB::connection('olddb');

    	$itemsPerBatch = 500;

    	$images = $old_db->table('tbl_image_library');

    	$this->command->getOutput()->progressStart($images->count());

    	$vellumImages = $images->orderBy('id')->chunk($itemsPerBatch, function($images){
    		foreach ($images as $image) {
    			$migratedImage = new ImageLibrary;
    			$migratedImage->create([
    				'id' => $image->id,
    				'photo_id' => $image->photo_id,
    				'path' => $image->path,
    				'contributor' => $image->contributor,
    				'contributor_fee' => $image->contributor_fee,
    				'tags' => $image->tags,
    				'alt_text' => isset($image->alt_text) ? $image->alt_text : NULL,
    				'illustrator' => $image->illustrator,
    				'created_at'=> ($image->date_created != '0000-00-00 00:00:00') ? $image->date_created : NULL,
    				'updated_at'=> ($image->date_modified != '0000-00-00 00:00:00') ? $image->date_modified : NULL
    			]);

    			$this->command->getOutput()->progressAdvance();
    		}
    	});

    	$this->command->getOutput()->progressFinish();
    }

}
