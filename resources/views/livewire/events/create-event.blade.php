<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">Create New Event</h2>
                
                @if (session()->has('message'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('message') }}
                    </div>
                @endif
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" wire:model="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="datetime-local" id="start_time" wire:model="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('start_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                        <input type="datetime-local" id="end_time" wire:model="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('end_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Create Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
