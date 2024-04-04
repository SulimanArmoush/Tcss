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
        Schema::create('hardwarekeys', function (Blueprint $table) {
            $table->id();

            $table->string('type')->nullable();
            $table->string('sereal')->nullable();
            $table->string('exDate')->nullable();
            $table->string('description')->nullable();

            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardwarekeys');
    }
};
