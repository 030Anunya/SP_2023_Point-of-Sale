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
        Schema::create('my_shops', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('shop_img')->nullable();
            $table->longText('shop_address')->nullable();
            $table->longText('line_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_shops');
    }
};
