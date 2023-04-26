<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pharmacy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'national_id',
        'avatar_image',
        'priority',
        'area_id'
    ];
    public function users()
    {
        return $this->morphMany(User::class, 'userable');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
