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
        'amenities',
        'price_per_night',
        'cleaning_fee',
        'security_deposit',
    ];

    protected $casts = [
        'amenities' => 'array',
    ];
}
