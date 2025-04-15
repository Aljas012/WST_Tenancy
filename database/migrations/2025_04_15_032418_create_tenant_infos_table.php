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
        Schema::create('tenant_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_application_id')
                ->constrained('tenant_applications')
                ->onDelete('cascade');
            $table->string('subscription_start_date')->nullable();
            $table->string('subscription_end_date')->nullable();
            $table->string('application_status')->nullable();
            $table->string('domain_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_infos');
    }
};
