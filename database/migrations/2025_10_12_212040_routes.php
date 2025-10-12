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
        Schema::create('routes_location', function(Blueprint $table){
            $table->id();
            $table->string('origin_route');
            $table->string('destination_route');
            $table->integer('base_price');
            $table->string('duration');
            $table->integer('distance');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes_location');
    }
};
