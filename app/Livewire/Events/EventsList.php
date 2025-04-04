<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class EventsList extends Component
{
    use WithPagination;
    
    public $search = '';
    
    protected $queryString = ['search'];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $events = Event::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy('start_time', 'asc')
            ->paginate(10);
            
        return view('livewire.events.events-list', [
            'events' => $events
        ]);
    }
}