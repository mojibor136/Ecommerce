<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('textlocals', function (Blueprint $table) {
            $table->id();
            $table->string('api_key')->nullable();
            $table->string('sender')->nullable();
            $table->string('url')->nullable();
            $table->string('provider')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('textlocals');
    }
};
