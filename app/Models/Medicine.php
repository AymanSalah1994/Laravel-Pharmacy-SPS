<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orders_medicines', 'order_id', 'medicine_id');
    }
}
