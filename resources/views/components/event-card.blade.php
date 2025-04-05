<div {{ $attributes->merge(['class' => 'border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition']) }}>
    <div class="p-4">
        <h3 class="text-xl font-semibold mb-2">{{ $event->title }}</h3>
        <div class="text-gray-600 mb-2">
            <div>Start: {{ $event->start_time->format('F j, Y, g:i a') }}</div>
            <div>End: {{ $event->end_time->format('F j, Y, g:i a') }}</div>
        </div>
        <p class="text-gray-600 mb-3">
            Organized by: {{ $event->creator->name ?? 'Unknown' }}
        </p>
        <p class="text-gray-700 mb-4 line-clamp-3">{{ $event->description }}</p>
        <div class="flex space-x-2">
            <a href="{{ route('events.show', $event) }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                View Details
            </a>
            <a href="{{ route('events.export', $event) }}" class="inline-block px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                <svg class="w-4 h-4 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export ICS
            </a>
        </div>
    </div>
</div>