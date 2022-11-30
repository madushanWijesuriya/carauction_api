<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInqueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inqueries', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['Wanted','Auction','Stock'])->nullable();
            $table->integer('vehicle_id');
            $table->string('name');
            $table->integer('country_id');
            $table->string('email');
            $table->string('cell_no');
            $table->string('port_name');
            $table->string('mobile_no');
            $table->string('message');
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
        Schema::dropIfExists('inqueries');
    }
}
