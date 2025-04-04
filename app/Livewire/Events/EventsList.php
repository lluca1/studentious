<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class EventsList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $myEvents = false;
    public $enrolledOnly = false;
    public $dateFrom = '';
    public $dateTo = '';
    
    protected $queryString = [
        'search',
        'myEvents',
        'enrolledOnly',
        'dateFrom',
        'dateTo'
    ];
    
    public function updating($name, $value)
    {
        if (in_array($name, ['search', 'myEvents', 'enrolledOnly', 'dateFrom', 'dateTo'])) {
            $this->resetPage();
        }
    }
    
    public function render()
    {
        $query = Event::query();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->dateFrom) {
            $query->where('start_time', '>=', $this->dateFrom . ' 00:00:00');
        }
        
        if ($this->dateTo) {
            $query->where('start_time', '<=', $this->dateTo . ' 23:59:59');
        }
        
        if ($this->myEvents) {
            $query->where('creator_id', Auth::id());
        }
        
        if ($this->enrolledOnly) {
            $query->whereHas('attendees', function($q) {
                $q->where('users.id', Auth::id());
            });
        }
        
        $events = $query->orderBy('start_time', 'asc')->paginate(10);
            
        return view('livewire.events.events-list', [
            'events' => $events
        ]);
    }
}