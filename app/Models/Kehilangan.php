<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehilangan extends Model
{
    use HasFactory;

    protected $table = 'datakehilangan';

    protected $fillable = [
        'kode_kehilangan',
        'peminjaman_id',
        'anggota_id',
        'buku_id',
        'tanggal_laporan',
        'keterangan',
        'denda',
        'status',
    ];

    // Relasi
    public function peminjaman() { return $this->belongsTo(Peminjaman::class, 'peminjaman_id'); }
    public function anggota() { return $this->belongsTo(Anggota::class, 'anggota_id'); }
    public function buku() { return $this->belongsTo(Buku::class, 'buku_id'); }

    // Auto Code Generator (KHL001)
    public static function createCode()
    {
        $latest = self::latest('id')->first();
        $number = $latest ? intval(substr($latest->kode_kehilangan, 3)) + 1 : 1;
        return 'KHL' . sprintf("%03d", $number);
    }
}
