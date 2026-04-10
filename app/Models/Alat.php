<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alats';

    protected $fillable = [
        'nama_alat',
        'deskripsi',
        'kategori_id',
        'harga24',
        'gambar',
        'harga48',
        'harga72'
    ];

    // relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    // relasi ke order
    public function order()
    {
        return $this->hasMany(Order::class,'alat_id','id');
    }
}