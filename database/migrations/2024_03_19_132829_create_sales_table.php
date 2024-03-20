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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            // id Users (vendedor)
            $table->unsignedBigInteger('id_seller');
            $table->foreign('id_seller')->references('id')->on('users');

            // id customers (cliente)
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id')->on('customers');

            $table->string('payment_method');
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
        Schema::dropIfExists('sales');
    }
};
