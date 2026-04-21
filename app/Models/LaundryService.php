<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaundryService extends Model
{
    protected $fillable = [
    'nama',
    'deskripsi',
    'harga',
    'satuan',
    'is_active'
];
}
