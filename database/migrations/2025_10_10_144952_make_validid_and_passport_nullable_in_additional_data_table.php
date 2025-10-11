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
    Schema::table('addtional_data', function (Blueprint $table) {
        $table->string('validId')->nullable()->change();
        $table->string('passport')->nullable()->change();
    });
}

public function down(): void
{
    Schema::table('addtional_data', function (Blueprint $table) {
        $table->string('validId')->nullable(false)->change();
        $table->string('passport')->nullable(false)->change();
    });
}

};
