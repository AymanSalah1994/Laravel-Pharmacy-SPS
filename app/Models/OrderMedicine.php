<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMedicine extends Model
{
    use HasFactory;
    protected $table = "orders_medicines";
    protected $fillable = [
        'order_id',
        'medicine_id',
        'type',
        'quantity',
        'price' // Still In Cents Here ! 
    ];
}
