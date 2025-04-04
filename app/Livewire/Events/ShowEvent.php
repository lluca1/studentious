<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;

class ShowEvent extends Component
{
    public Event $event;
    public $isAttending = false;
    
    public function mount(Event $event)
    {
        $this->event = $event;
        
        if (auth()->check()) {
            $this->isAttending = auth()->user()->events()->where('event_id', $this->event->id)->exists();
        }
    }
    
    public function toggleAttendance()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        if ($this->isAttending) {
            auth()->user()->events()->detach($this->event->id);
            session()->flash('message', 'You are no longer attending this event.');
        } else {
            auth()->user()->events()->attach($this->event->id);
            session()->flash('message', 'You are now attending this event!');
        }
        
        $this->isAttending = !$this->isAttending;
    }
    
    public function render()
    {
        return view('livewire.events.show-event', [
            'attendees' => $this->event->attendees()->get()
        ]);
    }
}