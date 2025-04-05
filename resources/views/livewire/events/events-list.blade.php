<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-container">
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
                
                <div class="mb-6 p-4 border shadow-sm hover:shadow-md transition rounded-lg">
                    <h3 class="font-medium mb-3">Filters</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">From Date</label>
                            <input type="date" wire:model.live="dateFrom" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">To Date</label>
                            <input type="date" wire:model.live="dateTo" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <div class="flex flex-col justify-end">
                            <label class="inline-flex items-center mt-2">
                                <input type="checkbox" wire:model.live="myEvents" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Only events created by me</span>
                            </label>
                            
                            <label class="inline-flex items-center mt-2">
                                <input type="checkbox" wire:model.live="enrolledOnly" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Only events I'm attending</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                @if (session()->has('message'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('message') }}
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($events as $event)
                        <x-event-card :event="$event" />
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
