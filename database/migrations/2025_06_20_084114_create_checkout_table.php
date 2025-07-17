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
       Schema::create('checkout', function (Blueprint $table) {
        $table->id();
        $table->string('resi')->unique();
        $table->dateTime('tanggal');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->json('keranjang_ids'); // disimpan dalam array JSON
        $table->enum('status', ['pending', 'verified'])->default('pending');
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout');
    }
};
