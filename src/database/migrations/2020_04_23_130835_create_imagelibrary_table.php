<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagelibraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_libraries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('photo_id')->nullable();
            $table->string('path', 255)->nullable();
            $table->string('contributor', 255)->nullable();
            $table->string('contributor_fee', 255)->nullable();
            $table->string('tags', 255)->nullable();
            $table->string('illustrator', 255)->nullable();
            $table->string('alt_text', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagelibraries');
    }
}
