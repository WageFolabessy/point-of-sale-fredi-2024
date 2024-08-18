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
        Schema::create('kasir_servis_keluhans', function (Blueprint $table) {
            $table->id();
            $table->string('kerusakan');
            $table->integer('biaya');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->integer('profit');
            $table->unsignedBigInteger('kasir_servis_id')->nullable();
            $table->foreign('kasir_servis_id')->references('id')->on('kasir_servis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kasir_servis_keluhans');
    }
};
