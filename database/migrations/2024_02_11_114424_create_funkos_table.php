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
        Schema::create('funkos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10)->default(0);
            $table->integer('stock')->default(0);
            $table->string('image')->default('https://via.placeholder.com/150');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funkos');
    }
};
