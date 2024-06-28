<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('car')
            ->orderBy('created_at', 'asc')
            ->orderBy('is_completed', 'desc')
            ->get();
        $rentalsCompleted = Rental::with('car')
            ->where('is_completed', 1)
            ->count();
        return view('rental.index', compact('rentals', 'rentalsCompleted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'duration' => 'required|integer',
            'total_price' => 'required|numeric',
            'proof_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi untuk bukti pembayaran
        ]);

        // Simpan bukti pembayaran
        if ($request->hasFile('proof_payment')) {
            $proofPath = $request->file('proof_payment')->storePublicly('proofs', 'public');
        } else {
            return redirect()->back()->with('danger', 'Proof of payment is required.');
        }

        // Buat rental baru
        $rental = Rental::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'duration' => $request->duration,
            'total_price' => $request->total_price,
            'is_completed' => false,
            'proof_payment' => $proofPath, // Simpan path bukti pembayaran di sini
        ]);

        return redirect()->route('rental.index')->with('success', 'Rental created successfully.');
    }



    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'title' => 'required|max:255',
            'car_id' => [
                'nullable',
                Rule::exists('cars', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
            ]
        ]);

        $rental->update([
            'title' => ucfirst($request->title),
            'car_id' => $request->car_id
        ]);

        return redirect()->route('rental.index')->with('success', 'Rent updated successfully!');
    }

    public function complete(Rental $rental)
    {
        // Check if the authenticated user is an admin
        if (auth()->user()->is_admin) {
            $rental->update([
                'is_completed' => 1,
            ]);
            return redirect()->route('rental.index')->with('success', 'Rental completed successfully!');
        } else {
            return redirect()->route('rental.index')->with('danger', 'Only admins can complete rentals!');
        }
    }

    public function uncomplete(Rental $rental)
    {
        // Check if the authenticated user is an admin
        if (auth()->user()->is_admin) {
            $rental->update([
                'is_completed' => 0,
            ]);
            return redirect()->route('rental.index')->with('success', 'Rental uncompleted successfully!');
        } else {
            return redirect()->route('rental.index')->with('danger', 'Only admins can uncomplete rentals!');
        }
    }





    public function destroy(Rental $rental)
    {
        $rental->delete();

        return redirect()->route('rental.index')
            ->with('success', 'Rental deleted successfully.');
    }


    public function destroyCompleted()
    {
        $rentalsCompleted = Rental::where('user_id', auth()->user()->id)
            ->where('is_completed', true)
            ->get();
        foreach ($rentalsCompleted as $rental) {
            $rental->delete();
        }

        return redirect()->route('rental.index')->with('success', 'All completed rentals deleted successfully!');
    }
}
