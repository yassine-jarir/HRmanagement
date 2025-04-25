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
        Schema::table('Tasks', function (Blueprint $table) {
            $table->enum('status', ['to_do', 'in_progress', 'completed'])->default('to_do')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Tasks', function (Blueprint $table) {
            //
        });
    }
};
