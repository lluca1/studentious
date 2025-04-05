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
            
            <div class="rounded-container">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">{{"Welcome back, " . auth()->user()->name . "!"}}</h3>
                        <a href="{{ route('dashboard.export-all-events') }}" class="primary-button bg-green-500 hover:bg-green-600">
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
                    
                    <div class="mt-8 border-t pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-md font-medium">Events matching your interests:</h4>
                            <a href="{{ route('profile.preferences') }}" class="flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm primary-button">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Update Preferences
                            </a>
                        </div>
                        
                        @if(count($taggedEvents) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($taggedEvents as $event)
                                    <x-event-card :event="$event" />
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                @if(count(auth()->user()->tags) > 0)
                                    <p class="text-gray-600">No events match your current interests.</p>
                                @else
                                    <p class="text-gray-600">You haven't selected any interests yet.</p>
                                    <a href="{{ route('profile.preferences') }}" class="mt-2 inline-block text-blue-500 hover:underline">
                                        Select your interests to see personalized event recommendations
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
