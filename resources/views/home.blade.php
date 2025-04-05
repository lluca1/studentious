@extends('layouts.app')

@section('content')
<div style="
    position: relative;
    min-height: 100vh;
    background: url('{{ asset('images/ChatGPT Image Apr 5, 2025, 05_57_33 PM.png') }}') no-repeat center center;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    z-index: 1;
    font-family: 'Poppins', sans-serif;
">
    <!-- Overlay -->
    <div style="
        position: absolute;
        inset: 0;
        background-color: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(3px);
        z-index: 1;
    "></div>

    <!-- Content -->
    <div style="
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 700px;
        padding: 1rem;
    ">
        <h1 style="
            font-size: 3rem;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 1rem;
        ">
            Welcome to Studentious
        </h1>

        <p style="
            font-size: 1.2rem;
            color: #374151;
            margin-bottom: 2rem;
            line-height: 1.6;
        ">
            Create and join collaborative learning sessions with ease. Sign up to start organizing or participating in group events.
        </p>

        @guest
            <div style="
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            ">
                <a href="{{ route('login') }}" style="
                    padding: 0.75rem 2rem;
                    border-radius: 0.5rem;
                    font-weight: 600;
                    font-size: 1rem;
                    background-color: #3b82f6;
                    color: white;
                    text-decoration: none;
                    transition: background-color 0.3s ease;
                " onmouseover="this.style.backgroundColor='#2563eb'" onmouseout="this.style.backgroundColor='#3b82f6'">Login</a>

                <a href="{{ route('register') }}" style="
                    padding: 0.75rem 2rem;
                    border-radius: 0.5rem;
                    font-weight: 600;
                    font-size: 1rem;
                    border: 2px solid #3b82f6;
                    background-color: transparent;
                    color: #3b82f6;
                    text-decoration: none;
                    transition: all 0.3s ease;
                " onmouseover="this.style.backgroundColor='#3b82f6'; this.style.color='white'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#3b82f6'">Register</a>
            </div>
        @else
            <a href="{{ route('dashboard') }}" style="
                padding: 0.75rem 2rem;
                border-radius: 0.5rem;
                font-weight: 600;
                font-size: 1rem;
                background-color: #10b981;
                color: white;
                text-decoration: none;
                transition: background-color 0.3s ease;
            " onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'">Go to Dashboard</a>
        @endguest
    </div>
</div>
@endsection
