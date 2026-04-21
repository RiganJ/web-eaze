<?php

use Illuminate\Support\Facades\File;

// Set permission folder storage/app/public
File::chmod(storage_path('app/public'), 0775);

// Set permission folder public/storage
File::chmod(public_path('storage'), 0775);

// Optional: rekursif semua subfolder dan file
function chmodRecursive($path, $perm = 0775) {
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($items as $item) {
        chmod($item, $perm);
    }
}

// Jalankan
chmodRecursive(storage_path('app/public'));
chmodRecursive(public_path('storage'));

echo "Permissions updated ✅";
