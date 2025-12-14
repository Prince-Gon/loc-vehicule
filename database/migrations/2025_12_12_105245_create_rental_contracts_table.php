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
        Schema::create('rental_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'active', 'expired', 'canceled'])->default('pending');
            $table->string('pdf_path')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index(['vehicle_id', 'start_date', 'end_date']); // For overlap checks
            $table->index(['start_date', 'end_date']);

            // For vehicle availability query
            $table->index(['vehicle_id', 'status', 'start_date', 'end_date'], 'vehicle_availability_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_contracts');
    }
};
