<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'keterangan',
        'price',
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
