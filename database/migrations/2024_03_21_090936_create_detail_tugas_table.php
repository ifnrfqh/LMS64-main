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
        Schema::create('detail_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tugas')->constrained('tugas')->onDelete('cascade');
            $table->string('nama_file');
            $table->string('path_file');
            $table->enum('tipe_file', ['dokumen', 'gambar']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_tugas');
    }
};
