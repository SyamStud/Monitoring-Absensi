<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'absensi';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'waktu_masuk',
        'waktu_keluar',
        'foto_pagar_depan',
        'foto_pagar_belakang',
        'foto_lorong_lab',
        'foto_ruang_tengah',
        'latitude',
        'longitude',
        'status',
        'tanggal',
    ];

    // Tipe data untuk kolom waktu
    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime',
    ];

    // Relasi dengan model User (User yang melakukan absensi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
