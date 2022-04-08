<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('day');
            $table->string('departure');
            $table->string('arrival');
            $table->float('price');
            $table->string('cityFrom');
            $table->string('cityTo');
            $table->string('traveler');
            //$table->foreignId('route_id')->references('id')->on('routes');//->onDelete('cascade');

        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('carrier_id')->nullable();

            $table->foreign('carrier_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
