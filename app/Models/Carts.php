<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'alat_id',
        'service_id',
        'harga',
        'durasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    public function service()
    {
        return $this->belongsTo(\App\Models\Service::class, 'service_id');
    }
}