@extends('layouts.app')

@section('title', 'Events')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Events') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <livewire:events.events-list />
    </div>
@endsection