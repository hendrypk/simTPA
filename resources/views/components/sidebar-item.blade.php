@props(['route', 'icon', 'label', 'permission'])

@php
    $hasPermission = auth()->user()->can($permission);
    $isActive = Route::is($route);
@endphp

@if($hasPermission)
    <li class="nav-item {{ $isActive ? 'active' : '' }}">
        <a class="nav-link" href="{{ route($route) }}">
            <i class="fas fa-fw {{ $icon }} {{ $isActive ? 'fa-bounce' : '' }}"></i>
            <span class="{{ $isActive ? 'bounce-text' : '' }}">{{ $label }}</span>
        </a>
    </li>
@endif
