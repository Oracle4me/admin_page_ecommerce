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
        Schema::create('warnas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produk')->constrained('produks')->cascadeOnDelete();

            $table->string('nama_warna', 30); 
            $table->string('kode_warna', 10)->nullable(); 
            $table->integer('qty')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warnas');
    }
};
