<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('code_departure')->references('code')->on('airports');
            $table->string('code_arrival')->references('code')->on('airports');
            $table->decimal('price', 15, 2);

            $table->foreign('code_departure')->on('airports')->references('code')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('code_arrival')->on('airports')->references('code')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
    }
}
