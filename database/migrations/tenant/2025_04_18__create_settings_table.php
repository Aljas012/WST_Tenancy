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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('color')->nullable();
            $table->string('font')->nullable();
            $table->boolean('layout')->default(false);
            $table->decimal('incentive_percentage', 5, 2)->nullable();
            $table->json('menu_order')->nullable();
            $table->timestamps();
        });
    }

    /** 2025_04_18_084525_create_settings_table
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
