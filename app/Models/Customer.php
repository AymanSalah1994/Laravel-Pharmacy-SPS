<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'gender', 'mobile_number', 'profile_image', 'national_id', 'dob'
    ];
    public function users()
    {
        return $this->morphMany(User::class, 'userable');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function setImageAttribute($value)
    {
        $attribute_name = "profile_image";
        $destination_path = public_path('/storage/customers');
        $profileImage = $value;
        $profileImageSaveAsName = time() . "-{$attribute_name}." . $profileImage->getClientOriginalExtension();
        $profile_image_url = $destination_path . $profileImageSaveAsName;
        $profileImage->move($destination_path, $profileImageSaveAsName);
        $this->attributes[$attribute_name] = $profileImageSaveAsName;
        return $profileImageSaveAsName;
    }
    public function setUpdatedImageAttribute($value)
    {
        if ($value) {
            // delete old image
            $this->deleteImage();
            $name = $this->setImageAttribute($value);
            return $name;
        }
    }
    public function deleteImage()
    {
        if ($this->image) {
            $imagePath = "dist/img/customers" . $this->image;
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }
    }
}
