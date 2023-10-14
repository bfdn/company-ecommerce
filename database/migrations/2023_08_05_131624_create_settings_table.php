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
            $table->string('logo')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->integer('category_products')->nullable();
            $table->integer('category_articles')->nullable();
            $table->integer('blog_articles')->nullable();
            $table->integer('home_products')->nullable();
            $table->integer('home_articles')->nullable();
            $table->integer('comments_status')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();

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
