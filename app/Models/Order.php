<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'menu_id',
        'buyer_name',
        'seat_number',
        'quantity',
        'preferences',
        'status',
    ];

    // Relasi ke menu
    public function menu()
    {
        return $this->belongsTo(MenuItem::class, 'menu_id');
    }

    // Relasi ke pembeli
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
