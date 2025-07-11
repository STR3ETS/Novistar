<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'user_id',
        'contact_information',
        'property_name',
        'location',
        'description',
        'max_guests',
        'amenities',
        'price_per_night',
        'cleaning_fee',
        'security_deposit',
    ];

    protected $casts = [
        'amenities' => 'array',
    ];

    public function photos()
    {
        return $this->hasMany(PropertyPhoto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
