<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'jenis_denda',
        'jumlah',
        'keterangan',
        'status_pembayaran'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}