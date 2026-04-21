<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolishOrder extends Model
{
    use HasFactory;

    protected $table = 'polish_orders';

    protected $fillable = [
        'order_code',
        'customer_name',
        'service_id',
        'vehicle_type',
        'price',
        'status',
        'order_date',
        'created_by'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
