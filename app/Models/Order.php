<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'service_id',
        'customer_name',
        'phone',
        'order_code',
        'order_date',
        'total_price',
        'status'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

