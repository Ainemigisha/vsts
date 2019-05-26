<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationFindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_finders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bus_id')->unsigned();
            $table->String('device_id');
            $table->timestamps();

            $table->index('bus_id');
            $table->index('device_id');
            $table->foreign('bus_id')->references('id')->on('buses')->onDelete('cascade');
            $table->foreign('device_id')->references('alphanumeric_string')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_finders');
    }
}
