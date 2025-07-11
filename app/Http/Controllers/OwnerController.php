<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;

class OwnerController extends Controller
{
    public function properties()
    {
        $properties = auth()->user()->properties;

        return view('dashboard.owner.properties', compact('properties'));
    }
    public function propertyCreate()
    {
        return view('dashboard.owner.property-setup');
    }
    public function propertyStore(Request $request)
    {
        $validated = $request->validate([
            'contact-information' => 'required|string',
            'property-name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'amenities' => 'nullable|array',
            'price-per-night' => 'required|numeric|min:1',
            'cleaning-fee' => 'required|numeric|min:1',
            'security-deposit' => 'required|numeric|min:1',
        ]);

        Property::create([
            'user_id' => auth()->id(),
            'contact_information' => $validated['contact-information'],
            'property_name' => $validated['property-name'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'amenities' => $validated['amenities'] ?? [],
            'price_per_night' => $validated['price-per-night'],
            'cleaning_fee' => $validated['cleaning-fee'],
            'security_deposit' => $validated['security-deposit'],
        ]);

        return redirect()->route('dashboard.owner.properties')->with('success', 'Property created successfully.');
    }
}
