<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paket extends Model
{
    use HasFactory;

    protected $fillable = ['nama_paket', 'kode_paket', 'barang_id', 'harga_paket', 'jadwal_id'];
}
