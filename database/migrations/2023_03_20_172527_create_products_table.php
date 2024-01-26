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
            $table->string('name');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('counts')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->string('count_type')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')
                ->onUpdate('set null')
                ->onDelete('set null');
            $table->foreign('property_id')->references('id')->on('properties')
                ->onUpdate('set null')
                ->onDelete('set null');
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
