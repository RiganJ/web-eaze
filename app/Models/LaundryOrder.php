<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class LaundryOrder extends Model
{
protected $fillable = [
    'batch_code',
    'order_code',
    'customer_name',
    'customer_phone',
    'service_id',
    'type',
    'weight',
    'qty',
    'total',
    'status',
    'order_date'
];


    // (OPSIONAL TAPI SANGAT DISARANKAN)
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
