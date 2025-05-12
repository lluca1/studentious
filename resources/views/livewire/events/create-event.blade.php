<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-container">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">Create New Event</h2>
                
                @if (session()->has('message'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('message') }}
                    </div>
                @endif
                <form wire:submit.prevent="save">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold border-b pb-2 mb-4">Event Details</h3>
                        
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
                        
                        <!-- Tags Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Event Tags</label>
                            <div class="mt-1 border border-gray-300 rounded-md p-2 bg-white shadow-sm">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($tags as $tag)
                                        <div class="flex items-center">
                                            <input id="tag-{{ $tag->id }}" wire:model="selectedTags" type="checkbox" value="{{ $tag->id }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <label for="tag-{{ $tag->id }}" class="ml-2 block text-sm text-gray-900">
                                                {{ $tag->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('selectedTags') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="includeCurriculum" wire:model.live="includeCurriculum" class="rounded border-gray-300 text-blue-600">
                            <label for="includeCurriculum" class="ml-2 text-sm font-medium text-gray-700">Upload curriculum</label>
                        </div>
                        
                        @if($includeCurriculum)
                            <div class="p-4 bg-gray-50 rounded-md">
                                <h3 class="text-lg font-semibold mb-4">Curriculum Details</h3>
                                
                                <div class="mb-4">
                                    <label for="curriculumTitle" class="block text-sm font-medium text-gray-700">Curriculum Title</label>
                                    <input type="text" id="curriculumTitle" wire:model="curriculumTitle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('curriculumTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="curriculumDescription" class="block text-sm font-medium text-gray-700">Curriculum Description (optional)</label>
                                    <textarea id="curriculumDescription" wire:model="curriculumDescription" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                    @error('curriculumDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="curriculumFile" class="block text-sm font-medium text-gray-700">PDF File</label>
                                    <input type="file" id="curriculumFile" wire:model="curriculumFile" accept=".pdf" class="mt-1 block w-full">
                                    <div class="mt-1 text-sm text-gray-500">Max file size: 10MB</div>
                                    @error('curriculumFile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    @if($curriculumFile)
                                        <div class="mt-2 text-sm text-green-600">File selected: {{ $curriculumFile->getClientOriginalName() }}</div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <button type="submit" class="primary-button bg-blue-500 hover:bg-blue-600">
                        Create Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
