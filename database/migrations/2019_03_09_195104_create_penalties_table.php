<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenaltiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penalties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('police_id')->unsigned();
            $table->bigInteger('location_finder_id')->unsigned();
            $table->DateTime('cleared_date');
            $table->timestamps();

            $table->index('police_id');
            $table->index('location_finder_id');
            $table->foreign('police_id')->references('id')->on('police')->onDelete('cascade');
            $table->foreign('location_finder_id')->references('id')->on('location_finders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penalties');
    }
}
