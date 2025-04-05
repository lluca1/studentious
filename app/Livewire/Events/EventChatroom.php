<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Log;

class EventChatroom extends Component
{
    public Event $event;
    public $messageContent = '';
    public $messages = [];
    public $showChat = false;
    
    #[Title('Event Chat')]
    public function mount(Event $event)
    {
        $this->event = $event;
        Log::info('EventChatroom mounted for event', ['event_id' => $event->id]);
        $this->loadMessages();
    }
    
    public function loadMessages()
    {
        Log::debug('Loading messages for event', ['event_id' => $this->event->id]);
        $this->messages = $this->event->messages()
            ->with('user')
            ->latest()
            ->take(100)
            ->get()
            ->reverse()
            ->values()
            ->toArray();
        Log::debug('Loaded messages count', ['count' => count($this->messages)]);
    }

    #[On('message-sent')]
    public function refreshMessages()
    {
        Log::info('Refreshing messages after new message');
        $this->loadMessages();
    }
    
    public function sendMessage()
    {
        Log::debug('sendMessage method called');
        
        if (!auth()->check()) {
            Log::warning('Unauthenticated user attempted to send message');
            return redirect()->route('login');
        }
        
        if (trim($this->messageContent) === '') {
            Log::debug('Empty message not sent');
            return;
        }
        
        Log::info('Creating new message', [
            'event_id' => $this->event->id,
            'user_id' => auth()->id(),
        ]);
        
        $message = Message::create([
            'event_id' => $this->event->id,
            'user_id' => auth()->id(),
            'content' => $this->messageContent,
        ]);
        
        $this->messageContent = '';
        
        Log::info('Message sent successfully', ['message_id' => $message->id]);
        $this->dispatch('message-sent');
    }
    
    public function toggleChat()
    {
        $this->showChat = !$this->showChat;
        Log::info('Chat visibility toggled', ['now_visible' => $this->showChat]);
        
        if ($this->showChat) {
            $this->loadMessages();
        }
    }
    
    public function render()
    {
        return view('livewire.events.event-chatroom');
    }
}
