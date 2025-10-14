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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->enum('role', ['Pilot', '', 'Cabin Crew', 'Ground Staff', 'Flight Manager', 'Finance Manager',]);
            $table->string('department');
            $table->enum('status', ['Active', 'Available', 'On Duty', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
