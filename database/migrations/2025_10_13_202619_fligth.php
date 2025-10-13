<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flightNo')->unique();
            $table->string('origin');
            $table->string('destination');
            $table->date('date');
            $table->string('time');
            $table->enum('status', ['On Time', 'Delayed', 'Cancelled'])->default('On Time');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
