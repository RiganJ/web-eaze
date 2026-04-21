<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonials';
    protected $fillable = [
        'name',
        'service',
        'message',
        'rating',
        'media',
        'media_type',
        'status'
    ];
    public $timestamps = true;
}
