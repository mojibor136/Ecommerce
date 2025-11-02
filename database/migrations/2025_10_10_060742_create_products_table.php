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
            $table->string('name');
            $table->string('slug');
            $table->string('brand')->nullable();
            $table->text('desc');
            $table->string('sku')->nullable()->unique();
            $table->integer('new_price')->nullable();
            $table->integer('old_price')->nullable();
            $table->integer('buy_price')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('category_id')->index();
            $table->integer('subcategory_id')->index();
            $table->string('orders')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('hot_deal')->default(0);
            $table->tinyInteger('type')->default(0);
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
