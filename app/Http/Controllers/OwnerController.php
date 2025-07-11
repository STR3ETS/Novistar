<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyPhoto;
use Illuminate\Support\Facades\Storage;

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
            'max-guests' => 'required|integer|min:1',
            'amenities' => 'nullable|array',
            'price-per-night' => 'required|numeric|min:1',
            'cleaning-fee' => 'required|numeric|min:1',
            'security-deposit' => 'required|numeric|min:1',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $property = Property::create([
            'user_id' => auth()->id(),
            'contact_information' => $validated['contact-information'],
            'property_name' => $validated['property-name'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'max_guests' => $validated['max-guests'],
            'amenities' => $validated['amenities'] ?? [],
            'price_per_night' => $validated['price-per-night'],
            'cleaning_fee' => $validated['cleaning-fee'],
            'security_deposit' => $validated['security-deposit'],
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                if ($photo && $photo->isValid()) {
                    $path = $photo->store('properties', 'public');

                    PropertyPhoto::create([
                        'property_id' => $property->id,
                        'path' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('dashboard.owner.properties')->with('success', 'Property created successfully.');
    }
}
