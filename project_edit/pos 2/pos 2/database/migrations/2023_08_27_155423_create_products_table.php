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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->longText('product_img')->nullable();
            $table->string('product_name');
            $table->decimal('product_price',14,2);
            $table->decimal('product_cost',14,2);
            $table->text('description')->nullable();
            $table->string('code');
            $table->integer('stock');
            $table->string('weight')->nullable();
            $table->string('Expiry_Date')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->integer('status')->default(1);
            $table->foreign('sub_category_id')->references('id')->on('subcategories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
