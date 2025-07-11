<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    public function show(Property $property)
    {
        return view('property', compact('property'));
    }
}
