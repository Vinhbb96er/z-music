<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('album_id')->nullable();
            $table->integer('region_id')->nullable();
            $table->integer('user_id');
            $table->string('url');
            $table->string('name');
            $table->tinyInteger('type');
            $table->text('lyrics')->nullable();
            $table->string('artist_name')->nullable();
            $table->string('lyrics_contributer_name')->nullable();
            $table->string('cover_image')->nullable();
            $table->bigInteger('views')->default(0);
            $table->tinyInteger('status');
            $table->string('path_media');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
