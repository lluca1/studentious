<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;

class CreateEvent extends Component
{
    public $title;
    public $description;
    public $start_time;
    public $end_time;
    
    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required|min:10',
        'start_time' => 'required|date|after_or_equal:now',
        'end_time' => 'required|date|after:start_time',
    ];
    
    public function save()
    {
        $this->validate();
        
        Event::create([
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'creator_id' => auth()->id(),
        ]);
        
        session()->flash('message', 'Event created successfully!');
        
        return redirect()->route('events.index');
    }
    
    public function render()
    {
        return view('livewire.events.create-event');
    }
}