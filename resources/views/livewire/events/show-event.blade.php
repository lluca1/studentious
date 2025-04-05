<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-container">
            <div class="p-6 text-gray-900">
                @if (session()->has('message'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('message') }}
                    </div>
                @endif
                
                <div class="mb-4">
                    <a href="{{ route('events.index') }}" class="text-blue-500 hover:underline">
                        &larr; Back to Events
                    </a>
                </div>
                
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-bold">{{ $event->title }}</h2>
                    
                    @auth
                        @if(auth()->id() === $event->creator_id)
                            <div class="flex space-x-2">
                                <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 primary-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                                
                                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 primary-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
                
                <div class="mb-2 flex flex-wrap gap-2">
                    <a href="{{ route('events.export', $event) }}" class="inline-block px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 primary-button">
                        <svg class="w-4 h-4 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export to Calendar
                    </a>
                    
                    <a href="{{ route('events.chat', $event) }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 primary-button">
                        <svg class="w-4 h-4 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Join Chat
                    </a>
                </div>
                
                <div class="mb-6">
                    <div class="text-gray-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Start: {{ $event->start_time->format('F j, Y, g:i a') }}</span>
                    </div>
                    <div class="text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>End: {{ $event->end_time->format('F j, Y, g:i a') }}</span>
                    </div>
                </div>
                
                <div class="mb-8">
                    <h3 class="text-xl font-semibold mb-3">About this event</h3>
                    <p class="whitespace-pre-line">{{ $event->description }}</p>
                </div>
                
                <div class="mb-8">
                    <h3 class="text-xl font-semibold mb-3">Organized by</h3>
                    <p>{{ $event->creator->name ?? 'Unknown' }}</p>
                </div>
                
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-xl font-semibold">Attendees ({{ $attendees->count() }})</h3>
                        @auth
                            <button wire:click="toggleAttendance" class="px-4 py-2 rounded-md {{ $isAttending ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white primary-button">
                                {{ $isAttending ? 'Cancel Attendance' : 'Attend this Event' }}
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Login to Attend
                            </a>
                        @endauth
                    </div>
                    
                    @if($attendees->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach($attendees as $attendee)
                                <div class="text-center">
                                    <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-2">
                                        <span class="text-gray-700 font-bold">{{ substr($attendee->name, 0, 1) }}</span>
                                    </div>
                                    <p class="text-sm">{{ $attendee->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No attendees yet. Be the first to attend!</p>
                    @endif
                    
                    @auth
                        <div class="mt-6 mb-8 border-t pt-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-xl font-semibold">Submit Curriculum</h3>
                                <button wire:click="toggleSubmitCurriculum" class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $showSubmitCurriculum ? 'M19 9l-7 7-7-7' : 'M9 5l7 7-7 7' }}" />
                                    </svg>
                                </button>
                            </div>
                    
                            @if (session()->has('curriculum_message'))
                                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                                    {{ session('curriculum_message') }}
                                </div>
                            @endif
                    
                            @if($showSubmitCurriculum)
                                <form action="{{ route('curricula.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    
                                    <div>
                                        <label class="block font-medium">Title</label>
                                        <input type="text" name="title" required class="border rounded p-2 w-full">
                                    </div>
                    
                                    <div>
                                        <label class="block font-medium">Description</label>
                                        <textarea name="description" class="border rounded p-2 w-full"></textarea>
                                    </div>
                    
                                    <div>
                                        <label class="block font-medium">Upload PDF</label>
                                        <input type="file" name="file" accept="application/pdf" class="block">
                                    </div>
                    
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit Curriculum</button>
                                </form>
                            @endif
                        </div>
                    @endauth
                    
                    <div class="mb-8 border-t pt-6">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-xl font-semibold">Uploaded Curricula ({{ count($curricula) }})</h3>
                            <button wire:click="toggleUploadedCurricula" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $showUploadedCurricula ? 'M19 9l-7 7-7-7' : 'M9 5l7 7-7 7' }}" />
                                </svg>
                            </button>
                        </div>
                    
                        @if($showUploadedCurricula)
                            @forelse ($curricula as $curriculum)
                                <livewire:curricula.curriculum-card :curriculum="$curriculum" :key="$curriculum->id" />
                            @empty
                                <p class="text-gray-500">No curricula uploaded yet for this event.</p>
                            @endforelse
                        @else
                            @if(count($curricula) < 1)
                                <p class="text-gray-500">No curricula uploaded yet for this event.</p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
