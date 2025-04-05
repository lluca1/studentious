<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\CalendarService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * The calendar service instance.
     *
     * @var \App\Services\CalendarService
     */
    protected $calendarService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\CalendarService $calendarService
     * @return void
     */
    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('events.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
        
        $event = Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'creator_id' => auth()->id(),
        ]);
        
        return redirect()->route('events.show', $event)
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        if (auth()->id() !== $event->creator_id) {
            return redirect()->route('events.show', $event)
                ->with('error', 'You are not authorized to edit this event.');
        }

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        if (auth()->id() !== $event->creator_id) {
            return redirect()->route('events.show', $event)
                ->with('error', 'You are not authorized to update this event.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if (auth()->id() !== $event->creator_id) {
            return redirect()->route('events.show', $event)
                ->with('error', 'You are not authorized to delete this event.');
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Export event as ICS file.
     *
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function export(Event $event)
    {
        $icsContent = $this->calendarService->generateEventIcs($event);

        return response($icsContent)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="event-' . $event->id . '.ics"');
    }
}
