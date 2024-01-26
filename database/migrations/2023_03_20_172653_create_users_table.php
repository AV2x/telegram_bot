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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('telegram_id')->nullable();
            $table->string('telegram_username')->nullable();
            $table->string('telegram_token')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('sex')->nullable();
            $table->integer('age')->nullable();
            $table->string('city')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->rememberToken();
            $table->integer('edit_type')->nullable();
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('set null')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
