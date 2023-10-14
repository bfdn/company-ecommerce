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
        Schema::table('categories', function (Blueprint $table) {
            $table->json("name")->change();
            $table->json("slug")->change();
            $table->json("content")->change()->nullable();
            $table->json("seo_keywords")->change()->nullable();
            $table->json("seo_description")->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // $table->dropColumn("image");
        });
    }
};
