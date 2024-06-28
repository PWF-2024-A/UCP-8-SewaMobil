<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'duration',
        'total_price',
        'is_completed',
        'proof_payment', // tambahkan proof_payment ke fillable
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function complete()
    {
        $this->update(['is_completed' => true]);
    }

    public function generateReceipt()
    {
        return "Receipt for Rental ID: $this->id, Car: $this->car->name, Total Price: $this->total_price";
    }
}
