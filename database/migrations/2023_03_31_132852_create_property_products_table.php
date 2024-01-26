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
        Schema::create('property_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('value');
            $table->timestamps();
            $table->foreign('property_id')->references('id')->on('properties')
                ->onUpdate('set null')
                ->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')
                ->onUpdate('set null')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_products');
    }
};
