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
        Schema::create('sale_item', function (Blueprint $table) {
            $table->id();
            // sales (vendas)
            $table->unsignedBigInteger('id_sale');
            $table->foreign('id_sale')->references('id')->on('sales');

            // products (produto)
            $table->unsignedBigInteger('id_product');
            $table->foreign('id_product')->references('id')->on('products');

            $table->integer('quantity');
            $table->double('price');
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
        Schema::dropIfExists('sale_item');
    }
};
