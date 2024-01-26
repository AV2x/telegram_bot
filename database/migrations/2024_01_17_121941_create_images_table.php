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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->string('file_name');
            $table->timestamps();
        });

        \App\Models\Image::create([
            'product_id' => 1,
            'file_name' => '1.jpg'
        ]);
        \App\Models\Image::create([
            'product_id' => 1,
            'file_name' => '2.jpg'
        ]);
        \App\Models\Image::create([
            'product_id' => 1,
            'file_name' => '3.jpg'
        ]);
        \App\Models\Image::create([
            'product_id' => 1,
            'file_name' => '4.jpg'
        ]);
        \App\Models\Image::create([
            'product_id' => 1,
            'file_name' => '5.jpg'
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
