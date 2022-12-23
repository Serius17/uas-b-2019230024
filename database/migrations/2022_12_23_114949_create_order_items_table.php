<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->char('item_id')->references('id')->on('items')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('order_id')->references('id')->on('orders')->constrained()->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->constrained()->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->constrained()->onDelete('cascade');
            $table->integer('quantity')->nullable();
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
        Schema::dropIfExists('order_items');
    }
}
