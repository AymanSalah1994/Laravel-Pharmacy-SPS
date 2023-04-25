<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable =[
        'area_id',
        'customer_id',
        'street_name',
        'building_number',
        'floor_number',
        'flat_number',
        'is_main',
    ];

    public function area()
    {
        // return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
        return $this->belongsTo(Area::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_id');
    }
}
