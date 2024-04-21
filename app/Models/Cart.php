<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['menu_id', 'qty', 'total'];

    public function get()
    {
        return request()->session()->get('cart');
    }

    public function set($cart)
    {
        request()->session()->put('cart', $cart);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
