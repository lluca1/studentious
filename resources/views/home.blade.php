@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 text-gray-800">
    <h1 class="text-4xl font-bold mb-4">Welcome to Studentious</h1>
    <p class="text-lg mb-6 text-center max-w-xl">Create and join collaborative learning sessions with ease. Sign up to start organizing or participating in group events.</p>

    @guest
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white">Register</a>
        </div>
    @else
        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Go to Dashboard</a>
    @endguest
</div>
@endsection
