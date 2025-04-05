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
            @if (session()->has('error'))
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">{{ __("Welcome back!") }}</h3>
                        <a href="{{ route('dashboard.export-all-events') }}" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Export All My Events
                        </a>
                    </div>
                    
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
