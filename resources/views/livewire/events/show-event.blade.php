{{-- resources/views/show-event.blade.php --}}

@extends('layouts.app')

@section('title', __('Event Details'))

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $event->title }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 py-10">
            @if (session('message'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg shadow">
                    {{ session('message') }}
                </div>
            @endif

            <div class="mb-6">
                <a href="{{ route('events.index') }}" class="text-blue-600 hover:underline text-sm">
                    &larr; Back to Events
                </a>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $event->title }}</h1>

            <div class="text-gray-500 mb-6">
                <p>📅 Start: {{ $event->start_time->format('F j, Y, g:i a') }}</p>
                <p>🕓 End: {{ $event->end_time->format('F j, Y, g:i a') }}</p>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">About this Event</h2>
                <p class="text-gray-800">{{ $event->description }}</p>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Organized By</h2>
                <p>{{ $event->creator->name ?? 'Unknown' }}</p>
            </div>

            <div class="mb-12">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Uploaded Curricula</h2>

                @forelse ($curricula as $curriculum)
                    <div class="border rounded-lg p-5 mb-6 bg-white shadow-sm">
                        <h3 class="text-lg font-bold">{{ $curriculum->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $curriculum->description }}</p>

                        @if ($curriculum->file_path)
                            <a href="{{ asset('storage/' . $curriculum->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                📄 View PDF
                            </a>

                            <form action="{{ route('generate.ai.summary') }}" method="POST" class="mt-3" onsubmit="showLoading(this)">
                                @csrf
                                <input type="hidden" name="pdf_path" value="{{ $curriculum->file_path }}">
                                <input type="hidden" name="curriculum_id" value="{{ $curriculum->id }}">
                                <button type="submit" class="generate-btn bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                    Generate Summary & Podcast
                                </button>
                            </form>
                        @endif

                        @if (session('ai_curriculum_id') == $curriculum->id && session('ai_summary'))
                            <div class="mt-4 p-4 bg-white border border-green-300 rounded shadow">
                                <h4 class="text-lg font-semibold text-green-700 mb-2">AI Summary</h4>
                                <p>{{ session('ai_summary') }}</p>

                                @if (session('ai_audio_url'))
                                    <h5 class="text-md font-semibold text-green-700 mb-2">Podcast</h5>
                                    <audio controls class="w-full">
                                        <source src="{{ session('ai_audio_url') }}" type="audio/mpeg">
                                        Your browser does not support audio.
                                    </audio>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">No curricula uploaded yet.</p>
                @endforelse
            </div>

            @if (session('ai_error'))
                <div class="p-4 bg-red-100 text-red-700 rounded">
                    {{ session('ai_error') }}
                </div>
            @endif
        </div>
    </div>

    <script>
    function showLoading(form) {
        const btn = form.querySelector('.generate-btn');
        btn.textContent = 'Generating...';
        btn.disabled = true;
    }
    </script>
@endsection
