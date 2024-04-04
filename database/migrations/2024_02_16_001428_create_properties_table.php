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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('CPU')->nullable();
            $table->string('Motherboard')->nullable();
            $table->string('RAM')->nullable();
            $table->string('Hard')->nullable();
            $table->string('Graphics')->nullable();
            $table->string('powerSupply')->nullable();
            $table->string('OS')->nullable();
            $table->string('NIC')->nullable();

            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
