<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    // Definisikan nama tabel secara manual
    protected $table = 'dataanggota';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'kode_anggota',
        'nama_anggota',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'jenis_anggota',
    ];

    public static function createCode()
    {
        $latestCode = self::orderBy('kode_anggota', 'desc')->value('kode_anggota');
        $latestCodeNumber = intval(substr($latestCode, 3));
        $nextCodeNumber = $latestCodeNumber ? $latestCodeNumber + 1 : 1;
        $formattedCodeNumber = sprintf("%03d", $nextCodeNumber);
        return 'AGT' . $formattedCodeNumber;
    }
}
