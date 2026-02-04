<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'databuku'; // Sesuaikan nama tabel

    protected $fillable = [
        'kode_buku',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'jenis_buku',
        'stok',
        'status',
    ];

    /**
     * Fungsi Otomatis Kode Buku Berdasarkan Jenis
     * Contoh: Fiksi -> FS001, Pelajaran -> PD001
     */
    public static function createCode($jenisBuku)
    {
        // 1. Tentukan Prefix berdasarkan Jenis Buku
        $prefix = match ($jenisBuku) {
            'Fiksi'     => 'FS',
            'Non-Fiksi' => 'NF',
            'Pelajaran' => 'PD', // Pendidikan
            'Referensi' => 'RF',
            'Jurnal'    => 'JR',
            'Majalah'   => 'MJ',
            default     => 'BK'
        };

        // 2. Cari buku terakhir yang punya prefix sama (misal cari yg depannya FS)
        $latest = self::where('kode_buku', 'like', $prefix . '%')
            ->orderBy('kode_buku', 'desc')
            ->value('kode_buku');

        // 3. Ambil nomor urutnya
        if (!$latest) {
            $number = 0;
        } else {
            // Ambil angka setelah prefix (FS005 -> ambil 005)
            $number = intval(substr($latest, 2));
        }

        // 4. Generate kode baru
        return $prefix . sprintf("%03d", $number + 1);
    }
}
