<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = ['nama_promo', 'kode_brg', 'diskon', 'qty_brg', 'jadwal_id'];
}
