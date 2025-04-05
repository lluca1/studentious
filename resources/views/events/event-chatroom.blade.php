@extends('layouts.app')

@section('title', __('Event Chatroom'))

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Event Chatroom') }}
    </h2>
@endsection

@section('content')
    <livewire:events.event-chatroom :event="$event" />
@endsection