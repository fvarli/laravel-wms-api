<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode')->unique();
            $table->integer('pallet_id')->unsigned();
            $table->enum('status', ['SCANNED','IN_WMS','TRANSFERRED'])->default('SCANNED');
            $table->timestamps();

            $table->foreign('pallet_id')->references('id')->on('pallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boxes');
    }
}
