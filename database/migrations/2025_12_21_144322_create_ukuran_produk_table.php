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
        Schema::create('ukurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produk')->constrained('produks')->cascadeOnDelete();

            $table->string('nama_ukuran', 20);
            $table->integer('qty')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukurans');
    }
};
