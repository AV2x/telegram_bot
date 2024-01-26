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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
//            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('status_id')->default(1)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_telephone');
            $table->timestamps();
//            $table->foreign('product_id')->references('id')->on('products')
//                ->onUpdate('set null')
//                ->onDelete('set null');
            $table->foreign('status_id')->references('id')->on('statuses')
                ->onUpdate('set null')
                ->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('set null')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('status_id');
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('orders');
    }
};
