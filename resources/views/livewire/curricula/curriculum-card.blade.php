<div class="border p-4 rounded mb-4">
    <h4 class="text-lg font-bold">{{ $curriculum->title }}</h4>
    <p class="text-sm text-gray-600 mb-2">{{ $curriculum->description }}</p>

    @if ($curriculum->file_path)
        <a href="{{ asset('storage/' . $curriculum->file_path) }}" target="_blank" class="text-blue-500 underline">
            View PDF
        </a>
    @endif

    <p class="text-xs text-gray-400 mt-2">
        Submitted by {{ $curriculum->user->name ?? 'Unknown' }} on {{ $curriculum->created_at->format('M d, Y') }}
    </p>
</div>
