<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;700&display=swap" rel="stylesheet">

<div class="studentious-wrapper">
    <div class="studentious-container">
        <div class="studentious-card">
            <div class="studentious-inner">
                <h2 class="studentious-heading">📚 Create New Event</h2>

                @if (session()->has('message'))
                    <div class="studentious-alert">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="save">
                    <div class="studentious-field">
                        <label for="title" class="studentious-label">Title</label>
                        <input type="text" id="title" wire:model="title" class="studentious-input">
                        @error('title') <span class="studentious-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="studentious-field">
                        <label for="description" class="studentious-label">Description</label>
                        <textarea id="description" wire:model="description" rows="4" class="studentious-textarea"></textarea>
                        @error('description') <span class="studentious-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="studentious-field">
                        <label for="start_time" class="studentious-label">Start Time</label>
                        <input type="datetime-local" id="start_time" wire:model="start_time" class="studentious-input">
                        @error('start_time') <span class="studentious-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="studentious-field">
                        <label for="end_time" class="studentious-label">End Time</label>
                        <input type="datetime-local" id="end_time" wire:model="end_time" class="studentious-input">
                        @error('end_time') <span class="studentious-error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="studentious-button">
                        ➕ Create Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
