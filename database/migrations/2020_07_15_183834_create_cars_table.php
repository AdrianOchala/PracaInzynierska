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
            $table->string('type',30);
            $table->year('production');
            $table->string('plate',7);
            $table->string('fuel',30);
            $table->string('engine',10);
            $table->string('transmission',15);
            $table->string('VIN',17)->unique();
            $table->date('service')->nullable();
            $table->string('mileage',8)->nullable();
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
