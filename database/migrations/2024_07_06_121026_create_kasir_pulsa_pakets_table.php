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
        Schema::create('kasir_pulsa_pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_hp');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->integer('profit');
            $table->text('keterangan')->nullable();
            $table->string('nama_kasir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kasir_pulsa_pakets');
    }
};
