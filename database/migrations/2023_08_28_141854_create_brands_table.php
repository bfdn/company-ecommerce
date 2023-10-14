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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger("user_id");
            $table->string("name");
            $table->string("slug");
            $table->boolean("status")->default(0);
            $table->timestamps();


            // $table->foreign("user_id")->on("users")->references("id");
            $table->foreignId('user_id')->constrained();
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
            // cascadeOnUpdate();
            // cascadeOnDelete();
            // nullOnDelete();
            // $table->foreignId('user_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
