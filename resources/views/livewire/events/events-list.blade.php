<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Upcoming Events</h2>
                    <div class="flex items-center">
                        <input type="text" wire:model.debounce.300ms="search" placeholder="Search events..." 
                            class="rounded-md border-gray-300 shadow-sm">
                        <a href="{{ route('events.create') }}" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Create Event
                        </a>
                    </div>
                </div>
                
                @if (session()->has('message'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('message') }}
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($events as $event)
                        <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
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
                                <a href="{{ route('events.show', $event) }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-4">
                            <p class="text-gray-500">No events found. Why not <a href="{{ route('events.create') }}" class="text-blue-500 hover:underline">create one</a>?</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-6">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
