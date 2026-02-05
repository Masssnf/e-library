<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // DEFINISIKAN NAMA TABEL KUSTOM
    protected $table = 'datapeminjaman';

    // Menggunakan $fillable agar lebih aman dan jelas kolom apa saja yang boleh diisi
    protected $fillable = [
        'kode_peminjaman',
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_wajib_kembali',
        'tanggal_pengembalian',
        'status',
    ];

    // Relasi ke Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    // Relasi ke Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    /**
     * Fungsi Otomatis Kode Peminjaman
     * Format: PJ001, PJ002, dst.
     */
    public static function createCode()
    {
        $latest = self::latest('id')->first();
        if (!$latest) {
            return 'PJ001';
        }

        $string = $latest->kode_peminjaman;
        // Asumsi format selalu PJ + 3 digit angka (total 5 char)
        // Ambil angka mulai index ke-2 (PJ...)
        $number = intval(substr($string, 2));
        $newNumber = $number + 1;

        return 'PJ' . sprintf("%03d", $newNumber);
    }
}
