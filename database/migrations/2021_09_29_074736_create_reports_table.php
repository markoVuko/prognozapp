<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('city_name');
            $table->string('country');
            $table->string('weather_name');
            $table->string('weather_desc');
            $table->double('temp_min',8,2);
            $table->double('temp_max',8,2);
            $table->integer('humidity');
            $table->integer('pressure');
            $table->dateTime('dt_txt');
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
        Schema::dropIfExists('reports');
    }
}
