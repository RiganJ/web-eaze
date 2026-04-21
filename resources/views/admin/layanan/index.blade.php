@extends('layouts.cms')

@section('title','Layanan')
@section('page-title','Daftar Layanan')

@section('content')

<div class="service-report">

@foreach($serviceConfig as $key => $config)

  <a href="{{ route('admin.layanan.orders', $key) }}"
     class="service-card {{ $config['class'] }}">

      <i class="fa-solid {{ $config['icon'] }}"></i>

      <h4>{{ $config['label'] }}</h4>

      <small>Kelola & pantau pesanan</small>

  </a>

@endforeach

</div>


@endsection
