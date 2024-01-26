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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->integer('analytics_graphics')->default(0);
            $table->integer('analytics_pie')->default(0);
            $table->integer('orders_create')->default(0);
            $table->integer('orders_edit')->default(0);
            $table->integer('orders_delete')->default(0);
            $table->integer('orders_view')->default(0);
            $table->integer('orders_export')->default(0);
            $table->integer('orders_status')->default(0);
            $table->integer('orders_executor')->default(0);
            $table->integer('users_create')->default(0);
            $table->integer('users_edit')->default(0);
            $table->integer('users_delete')->default(0);
            $table->integer('users_view')->default(0);
            $table->integer('roles_create')->default(0);
            $table->integer('roles_edit')->default(0);
            $table->integer('roles_delete')->default(0);
            $table->integer('roles_view')->default(0);
            $table->integer('roles_attach')->default(0);
            $table->integer('roles_detach')->default(0);
            $table->integer('categories_create')->default(0);
            $table->integer('categories_edit')->default(0);
            $table->integer('categories_delete')->default(0);
            $table->integer('categories_view')->default(0);
            $table->integer('products_create')->default(0);
            $table->integer('products_edit')->default(0);
            $table->integer('products_delete')->default(0);
            $table->integer('products_view')->default(0);
            $table->integer('products_import')->default(0);
            $table->integer('products_export')->default(0);
            $table->integer('settings_view')->default(0);
            $table->integer('settings_statuses_view')->default(0);
            $table->integer('settings_statuses_create')->default(0);
            $table->integer('settings_statuses_edit')->default(0);
            $table->integer('settings_statuses_delete')->default(0);
            $table->integer('settings_requisites_view')->default(0);
            $table->integer('settings_requisites_edit')->default(0);
            $table->integer('settings_properties_view')->default(0);
            $table->integer('settings_properties_create')->default(0);
            $table->integer('settings_properties_edit')->default(0);
            $table->integer('settings_properties_delete')->default(0);
            $table->integer('settings_storage_view')->default(0);
            $table->integer('settings_storage_create')->default(0);
            $table->integer('settings_storage_delete')->default(0);
            $table->integer('settings_telegram_view')->default(0);
            $table->integer('settings_telegram_link')->default(0);

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
        Schema::dropIfExists('permissions');
    }
};
