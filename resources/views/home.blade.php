@extends('layouts.app')

@section('content')
<div class="welcome-hero-wrapper">
    <div class="welcome-hero-overlay"></div>
    <div class="welcome-hero-container">
        <h1 class="welcome-hero-title">Welcome to Studentious</h1>
        <p class="welcome-hero-description">
            Create and join collaborative learning sessions with ease. Sign up to start organizing or participating in group events.
        </p>

        @guest
            <div class="welcome-hero-buttons">
                <a href="{{ route('login') }}" class="welcome-hero-btn welcome-hero-btn-primary">Login</a>
                <a href="{{ route('register') }}" class="welcome-hero-btn welcome-hero-btn-outline">Register</a>
            </div>
        @else
            <a href="{{ route('dashboard') }}" class="welcome-hero-btn welcome-hero-btn-success">Go to Dashboard</a>
        @endguest
    </div>
</div>
@endsection
