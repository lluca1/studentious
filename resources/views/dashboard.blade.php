@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('header')
    <h2 class="studentious-heading">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="studentious-wrapper">
        <div class="studentious-container">
            <div class="studentious-card">
                <div class="studentious-inner">
                    <div class="studentious-alert">
                        {{ __("You're logged in!") }}
                    </div>

                    <p class="text-gray-700 text-lg mb-6">
                        Welcome to your personalized learning hub. You can now create events, join group sessions, and manage your learning journey with ease.
                    </p>

                    <a href="{{ route('events.index') }}" class="studentious-button inline-block">
                        View Upcoming Events
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
