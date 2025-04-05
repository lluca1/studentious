<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

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
        $this->loadMessages();
    }
    
    public function loadMessages()
    {
        $this->messages = $this->event->messages()
            ->with('user')
            ->latest()
            ->take(100)
            ->get()
            ->reverse()
            ->values()
            ->toArray();
    }

    #[On('message-sent')]
    public function refreshMessages()
    {
        $this->loadMessages();
    }
    
    public function sendMessage()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        if (trim($this->messageContent) === '') {
            return;
        }
        
        $message = Message::create([
            'event_id' => $this->event->id,
            'user_id' => auth()->id(),
            'content' => $this->messageContent,
        ]);
        
        $this->messageContent = '';
        
        $this->dispatch('message-sent');
    }
    
    public function toggleChat()
    {
        $this->showChat = !$this->showChat;
        
        if ($this->showChat) {
            $this->loadMessages();
        }
    }
    
    public function getListeners()
    {
        return [
            'pollMessages' => 'deferLoadMessages'
        ];
    }

    public function deferLoadMessages()
    {
        $this->loadMessages();
    }
    
    public function render()
    {
        return view('livewire.events.event-chatroom');
    }
}
