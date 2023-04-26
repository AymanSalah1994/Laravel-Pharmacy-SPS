<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'delivering_address_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'delivering_address_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'order_id');
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'orders_medicines', 'order_id', 'medicine_id');
    }
}
