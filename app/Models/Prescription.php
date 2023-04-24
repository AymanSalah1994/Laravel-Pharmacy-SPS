<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'pre_image',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
