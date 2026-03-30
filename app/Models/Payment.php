<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Denda;
use App\Models\User;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    // ================= RELASI =================

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Order (1 Payment punya banyak Order)
    public function order()
    {
        return $this->hasMany(Order::class, 'payment_id', 'id');
    }

    // Relasi ke Denda 
 public function dendas()
{
    return $this->hasMany(\App\Models\Denda::class, 'payment_id');
}

    // ================= HELPER =================

    // Total denda dalam 1 transaksi
    public function getTotalDendaAttribute()
    {
        return $this->dendas->sum('jumlah');
    }

    // Total keseluruhan (sewa + denda)
    public function getGrandTotalAttribute()
    {
        return $this->total + $this->total_denda;
    }
}