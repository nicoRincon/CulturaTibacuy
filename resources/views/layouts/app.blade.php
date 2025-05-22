@extends('layouts.master')

@section('user-menu-items')
<a class="dropdown-item" href="{{ route('dashboard') }}">
    <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
</a>
@endsection

@section('content-wrapper')
<div class="container mt-4">
    @auth
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@yield('title')</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            @yield('actions')
        </div>
    </div>
    @endauth

    @yield('content')
</div>
@endsection