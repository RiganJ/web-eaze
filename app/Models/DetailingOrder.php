<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailingOrder extends Model
{
    use HasFactory;

    protected $table = 'detailing_orders';

    protected $fillable = [
        'order_code',
        'customer_name',
        'type',
        'vehicle_type',
        'total',
        'status',
        'order_date'
    ];
}
