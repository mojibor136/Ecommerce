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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->nullable();
            $table->string('name')->nullable();
            $table->string('headline')->nullable();
            $table->string('meta_title')->nullable();
            $table->date('hot_deals')->nullable();
            $table->json('meta_tag')->nullable();
            $table->json('shipping_charge')->nullable();
            $table->text('meta_desc')->nullable();
            $table->string('icon')->nullable();
            $table->string('favicon')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('open_time')->nullable();
            $table->text('footer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
