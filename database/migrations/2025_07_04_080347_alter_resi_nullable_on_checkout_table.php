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
         Schema::table('checkout', function (Blueprint $table) {
            // 1. Drop unique constraint dulu kalau ada
            $table->dropUnique(['resi']);

            // 2. Ubah jadi nullable
            $table->string('resi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkout', function (Blueprint $table) {
            // Rollback: ubah jadi NOT NULL + unique lagi
            $table->string('resi')->nullable(false)->change();
            $table->unique('resi');
        });
    }
};
