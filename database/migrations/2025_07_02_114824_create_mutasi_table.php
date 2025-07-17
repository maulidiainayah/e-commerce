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
       Schema::create('mutasi', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('idproduk');
        $table->enum('m_k', ['masuk', 'keluar']);
        $table->string('no_resi');
        $table->integer('qty');
        $table->integer('harga_satuan');
        $table->integer('subtotal');
        $table->dateTime('tanggal')->default(now());
        $table->timestamps();

    // Foreign key
    $table->foreign('idproduk')->references('id')->on('produks')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi')
        ;
    }
};
