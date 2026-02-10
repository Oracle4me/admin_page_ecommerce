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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('id_brand')->nullable()->constrained('brands')->onDelete('set null');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->text('imageUrl')->nullable();
            $table->string('tags');
            $table->string('slug');
            $table->string('sku')->unique();
            $table->decimal('harga', 12, 2);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
