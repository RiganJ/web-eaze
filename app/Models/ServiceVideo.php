<?php

// app/Models/ServiceVideo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceVideo extends Model
{
  protected $fillable = [
    'title',
    'description',
    'video_path',
    'thumbnail',
    'is_active'
  ];
}
