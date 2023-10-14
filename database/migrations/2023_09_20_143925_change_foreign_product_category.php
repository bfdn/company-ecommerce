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
        Schema::table('category_products', function (Blueprint $table) {
            //
            $table->dropForeign(['category_id']);
            $table->dropForeign(['product_id']);

            // $table->foreignId('category_id')->constrained();
            // $table->foreignId('product_id')->constrained();

            // $table->dropForeign('lists_user_id_foreign');
            // $table->dropIndex('lists_user_id_index');
            // $table->dropColumn('user_id');

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('product_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_products', function (Blueprint $table) {
            //
        });
    }
};
