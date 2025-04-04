@extends('layouts.app')

@section('content')
    <div class="py-12">
        <livewire:events.create-event />
    </div>
@endsection

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Create Event') }}
    </h2>
@endsection