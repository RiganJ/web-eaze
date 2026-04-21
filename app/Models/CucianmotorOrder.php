<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CucianMotorOrder extends Model
{
    use HasFactory;

    protected $table = 'cucian_motor_orders';

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_phone',
        'service_id',
        'vehicle_type',
        'status',
        'order_date',
        'created_by'
    ];

    // Tambahkan relasi ke service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    // Opsional: relasi ke admin yang buat order
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
}
