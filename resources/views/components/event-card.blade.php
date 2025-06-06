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
            <a href="{{ route('events.show', $event) }}" class="primary-button bg-blue-500 hover:bg-blue-600">
                View Details
            </a>
        </div>
    </div>
</div>