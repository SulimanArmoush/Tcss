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
        Schema::create('materials_installations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->foreignId('installation_service_id')->constrained('installation_services')->onDelete('cascade');

            $table->integer('quantity');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials_installations');
    }
};
