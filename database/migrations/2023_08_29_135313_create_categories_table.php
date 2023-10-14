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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('parent_id')->nullable()->constrained();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->foreignId('user_id')->constrained();
            $table->string("name");
            $table->string("slug");
            $table->boolean("status")->default(0);
            $table->string("content")->nullable();
            $table->integer("order")->default(0);
            $table->string("seo_keywords")->nullable();
            $table->string("seo_description")->nullable();
            $table->timestamps();


            $table->foreign("parent_id")->on("categories")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
