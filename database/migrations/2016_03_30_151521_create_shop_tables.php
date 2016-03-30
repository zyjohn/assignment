<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $product) {
            $product->increments('id');
            $product->string('name');
            $product->string('summary');
            $product->string('preview');
            $product->string('content');
            $product->decimal('price', 5, 2);
            $product->timestamps();
        });

        Schema::create('product_option', function (Blueprint $product_option) {
            $product_option->increments('id');
            $product_option->string('color');
            $product_option->string('size');
            $product_option->integer('product_id')->unsigned();
            $product_option->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('cascade');
            $product_option->timestamps();
            $product_option->unique(['product_id','color','size']);
        });

        Schema::create('cart', function (Blueprint $cart) {
            $cart->increments('id');
            $cart->integer('user_id')->unsigned();
            $cart->integer('product_id')->unsigned();
            $cart->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('cascade');
            $cart->integer('option_id')->unsigned();
            $cart->foreign('option_id')
                ->references('id')
                ->on('product_option')
                ->onDelete('cascade');
            $cart->integer('quantity');
            $cart->timestamps();
            $cart->unique(['user_id','product_id','option_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cart');
        Schema::drop('product_option');
        Schema::drop('product');
    }
}
