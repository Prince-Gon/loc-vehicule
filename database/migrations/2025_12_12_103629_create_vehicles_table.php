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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('model', 100);
            $table->string('license_plate',20)->unique();
            $table->year('year');
            $table->integer('kilometers')->default(0);
            $table->decimal('rental_price_per_day', 8, 2);
            $table->enum('availability_status', ['available', 'reserved', 'maintenance'])->default('available');
            $table->enum('vehicle_type', ['sedan', 'suv', 'truck', 'van', 'wagon', 'hatchback']);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('availability_status');
            $table->index(['brand_id', 'availability_status']);
            $table->index('license_plate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
