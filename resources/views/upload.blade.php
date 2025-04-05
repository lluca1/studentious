@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold mb-4">Upload a PDF to Generate Summary + Podcast</h1>

    <form method="POST" action="{{ route('process.pdf') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="pdf" class="mb-4 block w-full" accept="application/pdf" required>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Generate Podcast & Summary
        </button>
    </form>

    @if(session('summary'))
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-2">Summary:</h2>
            <div class="bg-white p-4 shadow rounded mb-6">{{ session('summary') }}</div>

            <h2 class="text-xl font-semibold mb-2">Podcast:</h2>
            <audio controls>
                <source src="{{ session('audio_url') }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
    @endif
</div>
@endsection
