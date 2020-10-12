<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('carModel_id');
            $table->foreign('carModel_id')->references('id')->on('car_models');
            $table->string('type');
            $table->year('production');
            $table->string('plate');
            $table->string('fuel');
            $table->string('engine');
            $table->string('transmission');
            $table->string('VIN')->unique();
            $table->date('service')->nullable();
            $table->string('mileage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
