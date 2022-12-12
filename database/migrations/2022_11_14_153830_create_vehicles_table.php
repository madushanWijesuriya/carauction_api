<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('make_id');
            $table->integer('model_id');
            $table->integer('status_id');
            $table->integer('body_type_id');
            $table->integer('transmission_id');
            $table->integer('streeing_id');
            $table->integer('door_type_id');
            $table->integer('driver_type_id');
            $table->integer('fuel_type_id');
            $table->integer('exterior_color_id');
            $table->integer('feature_id');
            $table->date('make_at');
            $table->double('fob_price');
            $table->string('chassis_no');
            $table->string('displacement');
            $table->string('grade');
            $table->string('cover_image_full_url')->nullable();
            $table->string('cover_image_file')->nullable();
            $table->text('description');
            $table->text('private_note');
            $table->string('sup_name');
            $table->string('sup_url');
            $table->double('sup_price');
            $table->double('market_price');
            $table->boolean('isUsed')->default(true);
            $table->double('mileage');
            $table->softDeletes();
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
        Schema::dropIfExists('vehicles');
    }
}
