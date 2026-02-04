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
        Schema::create('databuku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku')->unique(); // Pengganti kd_koleksi
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->integer('stok');
            $table->year('tahun_terbit');
            
            // Tambahan "Jenis-Jenis Buku" sesuai permintaan
            $table->enum('jenis_buku', [
                'Fiksi', 
                'Non-Fiksi', 
                'Pelajaran', 
                'Referensi', 
                'Jurnal', 
                'Majalah'
            ]);
            
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Hilang', 'Rusak'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databuku');
    }
};
