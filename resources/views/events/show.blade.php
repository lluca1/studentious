@extends('layouts.app')

@section('title', __('Event Details'))

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Event Details') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <livewire:events.show-event :event="$event" />
    </div>
@endsection