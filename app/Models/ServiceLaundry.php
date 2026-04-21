<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceLaundry extends Model
{
     use HasFactory;

    protected $table = 'laundry_services';

    protected $fillable = [
        'layanan',
        'kategori',
        'harga',
        'satuan',
        'durasi',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'harga'     => 'integer',
        'is_active' => 'boolean',
    ];
}
