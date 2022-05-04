<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather', function (Blueprint $table) {
            $table->id();

            $table->integer("city_id");
            $table->time("dt");
            $table->string("main");
            $table->string("description");
            $table->string("temp");
            $table->string("feels_like");
            $table->string("temp_min");
            $table->string("temp_max");
            $table->string("pressure");
            $table->string("humidity");
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');

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
        Schema::dropIfExists('weather');
    }
};
