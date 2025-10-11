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
        Schema::create('addtional_data', function(Blueprint $table){
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('contact');
            $table->enum('gender',['male','female','prefer not to say']);
            $table->date('memberDate');
            $table->string('validId')->nullable();
            $table->string('passport')->nullable();
            $table->string('block');
            $table->string('barangay');
            $table->string('municipality');
            $table->string('province');
            $table->string('country');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addtional_data');
    }
};
