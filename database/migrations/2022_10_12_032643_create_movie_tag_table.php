<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->index('movie_id');
            $table->index('tag_id');

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete("cascade")->onUpdate("cascade");

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_tags');
    }
}
