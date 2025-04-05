<?php

namespace App\View\Components;

use App\Models\Event;
use Illuminate\View\Component;

class EventCard extends Component
{
    /**
     * The event to display.
     *
     * @var \App\Models\Event
     */
    public $event;

    /**
     * Create a new component instance.
     *
     * @param \App\Models\Event $event
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.event-card');
    }
}