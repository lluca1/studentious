@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">{{ __("Welcome back!") }}</h3>
                    
                    <div class="mt-6">
                        <h4 class="text-md font-medium mb-3">Your next upcoming event:</h4>
                        
                        @if($nextEvent)
                            <div class="mt-2">
                                <x-event-card :event="$nextEvent" />
                            </div>
                        @else
                            <p class="text-gray-600">You don't have any upcoming events. 
                                <a href="{{ route('events.index') }}" class="text-blue-500 hover:underline">
                                    Browse events
                                </a> to join one!
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
