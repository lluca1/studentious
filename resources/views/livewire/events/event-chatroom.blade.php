<div wire:poll.5s="$dispatch('pollMessages')">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-container">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $event->title }} - Chat</h2>
                            <p class="text-gray-600">
                                <a href="{{ route('events.show', $event) }}" class="text-blue-500 hover:underline">
                                    &larr; Back to Event
                                </a>
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">{{ $event->attendees->count() }} attendees</span>
                        </div>
                    </div>
                    
                    <div class="border rounded-lg">
                        <div class="h-[60vh] overflow-y-auto p-4 space-y-3 bg-gray-50 rounded-t-lg" id="messages-container">
                            @forelse($messages as $message)
                                <div class="flex space-x-2 {{ $message['user_id'] == auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-md p-3 rounded-lg {{ $message['user_id'] == auth()->id() ? 'bg-blue-100' : 'bg-gray-200' }}">
                                        <div class="font-semibold text-sm text-gray-600">
                                            {{ $message['user']['name'] ?? 'Unknown' }}
                                            <span class="text-xs text-gray-400 ml-1">
                                                {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
                                            </span>
                                        </div>
                                        <div class="mt-1">
                                            {{ $message['content'] }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 py-4">
                                    No messages yet. Be the first to send a message!
                                </div>
                            @endforelse
                        </div>
                        
                        <!-- Message Input -->
                        @auth
                            <div class="border-t p-4">
                                <form wire:submit.prevent="sendMessage" class="flex gap-2">
                                    <input 
                                        wire:model="messageContent" 
                                        type="text" 
                                        placeholder="Type your message..." 
                                        class="flex-1 border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        autofocus
                                    >
                                    <button 
                                        type="submit" 
                                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                        Send
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-center bg-gray-50 p-3 border-t">
                                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login to join the conversation</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:initialized', () => {
    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        @this.on('message-sent', () => {
            setTimeout(() => {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }, 100);
        });
    }
});
</script>