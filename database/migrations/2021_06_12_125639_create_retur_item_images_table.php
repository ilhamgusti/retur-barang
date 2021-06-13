<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturItemImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_item_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('retur_id')->nullable();
            $table->foreign('retur_id')->references('id')->on('retur_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retur_item_images');
    }
}
