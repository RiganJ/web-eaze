<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KarsobedOrder extends Model
{
    use HasFactory;

    protected $table = 'karsobed_orders';

    protected $fillable = [
        'order_code',
        'customer_name',
        'service_id',
        'bed_type',
        'price',
        'status',
        'order_date',
        'created_by'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
}
