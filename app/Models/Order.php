<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // relasi ke alat
    public function alat()
    {
        return $this->belongsTo(Alat::class,'alat_id');
    }

    // relasi ke service
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    // relasi ke payment
    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id');
    }
    // denda
    public function dendas()
{
    return $this->hasOne(Denda::class);
}
}

