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
        Schema::create('peripherals', function (Blueprint $table) {
            $table->id();

            $table->string('Monitor')->nullable();
            $table->string('Keyboard')->nullable();
            $table->string('Mouse')->nullable();
            $table->string('Printer')->nullable();
            $table->string('UPS')->nullable();
            $table->string('cashBox')->nullable();
            $table->string('Barcode')->nullable();
 
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peripherals');
    }
};
