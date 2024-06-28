<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function create()
    {
        return view('car.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'license' => 'required|string|max:20',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $imagePath = $request->file('image')->store('car_images', 'public');

        Car::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'type' => $request->type,
            'license' => $request->license,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('car.index')->with('success', 'Car created successfully.');
    }

    public function edit(Car $car)
    {
        return view('car.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'license' => 'required|string|max:20',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        // Update fields from the request
        $car->name = $request->name;
        $car->brand = $request->brand;
        $car->type = $request->type;
        $car->license = $request->license;
        $car->price = $request->price;

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Validate and store new image
            $imagePath = $request->file('image')->store('car_images', 'public');

            // Delete old image if it exists
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }

            // Update car's image attribute
            $car->image = $imagePath;
        }

        // Save the car instance with updated data
        $car->save();

        // Redirect back to car index with success message
        return redirect()->route('car.index')->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car)
    {
        // Delete car image
        Storage::disk('public')->delete($car->image);

        // Delete car record
        $car->delete();

        return redirect()->route('car.index')->with('success', 'Car deleted successfully.');
    }

    public function index()
    {
        $cars = Car::all();
        return view('car.index', compact('cars'));
    }
}
