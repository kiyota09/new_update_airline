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
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->string('departure');
            $table->string('destination');
            $table->date('departureDate');
            $table->date('returnDate');
            $table->string('passengers');
            $table->string('tripType');
            $table->string('flightClasses');
            $table->json('data')->nullable(); // store chart data or filters
            $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
