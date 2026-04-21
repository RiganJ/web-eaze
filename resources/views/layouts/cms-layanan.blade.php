<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>@yield('title') - CMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('layouts.partials.vite-tailwind')
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/cms.css') }}">
</head>
<body>

<div class="cms-wrapper">
  @include('layouts.admin-laundry')

  <div class="cms-main">
    @include('layouts.topbar')
    @yield('content')
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')
</body>
</html>
