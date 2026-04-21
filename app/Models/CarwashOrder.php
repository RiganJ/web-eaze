<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarwashOrder extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'carwash_orders';

    // Primary key
    protected $primaryKey = 'id';

    // Field yang bisa diisi massal
    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_phone',
        'vehicle_type',
        'service_id',
        'price',
        'status',
        'scheduled_at',
        'created_by',
        'order_date',
    ];

    // Timestamps (created_at, updated_at)
    public $timestamps = true;

    /**
     * Relasi ke tabel Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Relasi ke Admin yang membuat order
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
