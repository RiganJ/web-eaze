@php
    $entrypoints = $entrypoints ?? ['resources/css/app.css'];
    $hasViteBuild = file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'));
@endphp

@if ($hasViteBuild)
    @vite($entrypoints)
@endif
