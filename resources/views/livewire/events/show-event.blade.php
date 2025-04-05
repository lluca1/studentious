<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
                
                <h2 class="text-3xl font-bold mb-2">{{ $event->title }}</h2>
                <div class="mb-2">
                    <a href="{{ route('events.export', $event) }}" class="inline-block px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        <svg class="w-4 h-4 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export to Calendar
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
                            <button wire:click="toggleAttendance" class="px-4 py-2 rounded-md {{ $isAttending ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white">
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
