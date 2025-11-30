<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPagesTable extends Migration
{
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('product_variant_id')->nullable();
            $table->string('product_type')->nullable();
            $table->string('campaign_title')->nullable();
            $table->text('campaign_description')->nullable();
            $table->json('banner_image')->nullable();
            $table->json('review_image')->nullable();
            $table->string('video_url')->nullable();
            $table->string('description_title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('why_buy_from_us')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('landing_pages');
    }
}
