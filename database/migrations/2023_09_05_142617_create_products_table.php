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
            $table->foreignId('user_id')->constrained();
            $table->json("name");
            $table->json("slug");
            $table->json("content")->nullable();
            $table->json("images")->nullable();
            $table->boolean("status")->default(0);
            $table->decimal("price", 10, 2);
            $table->tinyInteger("tax");
            $table->json("seo_keywords")->nullable();
            $table->json("seo_description")->nullable();
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
