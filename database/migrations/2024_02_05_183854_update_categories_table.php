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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('funkos');
        Schema::dropIfExists('categories');
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('is_deleted')->default(false);
            $table->timestamps();
        });
        Schema::create('funkos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10)->default(0);
            $table->integer('stock')->default(0);
            $table->string('image')->default('https://via.placeholder.com/150');
            $table->foreignUuid('category_id')->references('id')->on('categories');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }


};
