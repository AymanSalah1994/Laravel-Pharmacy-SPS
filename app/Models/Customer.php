<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
       'gender','mobile_number','profile_image','national_id','dob'
    ];
    public function users()
    {
        return $this->morphMany(User::class, 'userable');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }
}
