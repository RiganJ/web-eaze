<?php

// database/migrations/xxxx_create_service_videos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('service_videos', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description')->nullable();
      $table->string('video_path');
      $table->string('thumbnail');
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('service_videos');
  }
};

