@extends('layouts.app')

@section('content')
<div class="relative min-h-screen overflow-hidden">
    <!-- Background Image -->
    <img src="{{ asset('images/home-bg.png') }}" alt="Background" class="absolute inset-0 w-full h-full object-cover z-0">

    <!-- Glassmorphism Wrapper -->
    <div class="home-wrapper relative z-10">
        <div class="glass-card text-center">
            <h1 class="home-title home-text">Welcome to Studentious</h1>
            <p class="home-subtitle home-text">
                Create and join collaborative learning sessions with ease. Sign up to start organizing or participating in group events.
            </p>

            @guest
                <div class="home-buttons">
                    <a href="{{ route('login') }}" class="home-btn-primary primary-button">Login</a>
                    <a href="{{ route('register') }}" class="home-btn-secondary primary-button">Register</a>
                </div>
            @else
                <a href="{{ route('dashboard') }}" class="home-btn-dashboard primary-button">Go to Dashboard</a>
            @endguest
        </div>
    </div>
</div>
@endsection
