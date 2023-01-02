<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_docs', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id');
            $table->integer('country_id');
            $table->integer('customer_id');
            $table->date('etd');
            $table->date('eta');
            $table->string('doc_1');
            $table->string('doc_2');
            $table->string('doc_3');
            $table->string('pol');
            $table->string('pod');
            $table->string('consignee_name');
            $table->string('yard_location');
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
        Schema::dropIfExists('vehicle_docs');
    }
}
