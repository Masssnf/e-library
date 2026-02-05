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
        Schema::create('datapeminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman')->unique(); // Tambahan Kode Peminjaman

            // Relasi ke tabel dataanggota
            $table->foreignId('anggota_id')->constrained('dataanggota')->onDelete('cascade');
            // Relasi ke tabel databuku
            $table->foreignId('buku_id')->constrained('databuku')->onDelete('cascade');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_wajib_kembali'); // Deadline (Otomatis +7 hari)
            $table->date('tanggal_pengembalian')->nullable(); // Diisi saat buku balik

            $table->enum('status', ['Dipinjam', 'Dikembalikan', 'Telat'])->default('Dipinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datapeminjaman');
    }
};
