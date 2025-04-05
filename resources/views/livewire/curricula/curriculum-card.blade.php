<div class="border p-4 rounded mb-4">
    <h4 class="text-lg font-bold">{{ $curriculum->title }}</h4>
    <p class="text-sm text-gray-600 mb-2">{{ $curriculum->description }}</p>

    <div class="flex flex-wrap gap-3 mb-3">
        @if ($curriculum->file_path)
            <a href="{{ asset('storage/' . $curriculum->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                View PDF
            </a>
        @endif
        
        @if ($curriculum->ai_summary || $curriculum->ai_audio_url)
            <button wire:click="toggleAiContent" class="inline-flex items-center px-3 py-1 bg-purple-500 text-white text-sm rounded hover:bg-purple-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                {{ $showAiContent ? 'Hide AI Content' : 'Show AI Summary & Audio' }}
            </button>
        @else
            <button wire:click="generateAiContent" wire:loading.attr="disabled" class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span wire:loading.remove wire:target="generateAiContent">Generate AI Summary & Audio</span>
                <span wire:loading wire:target="generateAiContent">Processing...</span>
            </button>
        @endif
    </div>
    
    @if ($processingError)
        <div class="p-3 mt-2 text-sm text-red-700 bg-red-100 rounded-lg">
            {{ $processingError }}
        </div>
    @endif
    
    @if (session('ai_error'))
        <div class="p-3 mt-2 text-sm text-red-700 bg-red-100 rounded-lg">
            {{ session('ai_error') }}
        </div>
    @endif
    
    @if ($generating)
        <div class="p-3 mt-2 flex items-center bg-blue-50 text-blue-700 rounded-lg">
            <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>AI processing in progress...</span>
        </div>
    @endif
    
    @if ($showAiContent && ($curriculum->ai_summary || $curriculum->ai_audio_url))
        <div class="mt-3 p-4 bg-gray-50 rounded-lg">
            @if ($curriculum->ai_summary)
                <h5 class="font-semibold mb-2">AI Summary</h5>
                <p class="text-sm mb-3">{{ $curriculum->ai_summary }}</p>
            @endif
            
            @if ($curriculum->ai_audio_url)
                <h5 class="font-semibold mb-2">Audio</h5>
                <audio controls class="w-full">
                    <source src="{{ $curriculum->ai_audio_url }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            @endif
        </div>
    @endif

    <p class="text-xs text-gray-400 mt-2">
        Submitted by {{ $curriculum->user->name ?? 'Unknown' }} on {{ $curriculum->created_at->format('M d, Y') }}
    </p>
</div>
