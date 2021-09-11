<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->integer('tvmaze_id');
            $table->text('name');
            $table->double('rating')->nullable();
            $table->text('imdb_id')->nullable();
            $table->text('image_url')->nullable();
            $table->integer('nextepisode_season')->nullable();
            $table->integer('nextepisode_episode')->nullable();
            $table->text('nextepisode_url')->nullable();
            $table->string('nextepisode_airstamp')->nullable();
            $table->boolean('popular')->default(1);
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
        Schema::dropIfExists('shows');
    }
}
