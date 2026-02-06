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
        Schema::create('datakehilangan', function (Blueprint $table) {
        $table->id();
        $table->string('kode_kehilangan')->unique(); // KHL001
        
        // Relasi ke tabel terkait
        $table->foreignId('peminjaman_id')->constrained('datapeminjaman')->onDelete('cascade');
        $table->foreignId('anggota_id')->constrained('dataanggota')->onDelete('cascade');
        $table->foreignId('buku_id')->constrained('databuku')->onDelete('cascade');
        
        $table->date('tanggal_laporan');
        $table->text('keterangan'); // Hilang / Rusak Berat / Rusak Ringan
        $table->decimal('denda', 10, 2)->default(0); // Nominal denda
        
        $table->enum('status', ['Diajukan', 'Konfirmasi', 'Selesai', 'Ditolak'])->default('Diajukan');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datakehilangan');
    }
};
