<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomecleanOrder extends Model
{
    protected $table = 'homeclean_orders';
protected $fillable = [
    'batch_code',
    'order_code',
    'customer_name',
    'customer_phone',
    'service_type',   // FK ke services
    'unit_value',     // meter / pcs / jam
    'manual_price',   // hanya diisi jika service.price NULL
    'total',
    'status',
    'order_date',
];
public function service()
{
    return $this->belongsTo(Service::class, 'service_type');
}

}
