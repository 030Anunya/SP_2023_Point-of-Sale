<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->decimal('product_cost',8,2);
            $table->decimal('product_price',8,2);
            $table->integer('product_qty');
            $table->decimal('product_total_price',8,2);
            $table->decimal('vat',8,2);
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('feature')->nullable();
            $table->unsignedBigInteger('listsale_id');
            $table->foreign('listsale_id')->references('id')->on('listsales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
