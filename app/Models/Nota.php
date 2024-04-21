<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;
    public $guarded = [];
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
