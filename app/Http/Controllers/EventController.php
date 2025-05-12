<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Curriculum;
use App\Models\Tag;
use App\Services\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    protected $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function index()
    {
        return view('events.index');
    }

    public function create()
    {
        return view('events.create');
    }

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

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        if (auth()->id() !== $event->creator_id) {
            return redirect()->route('events.show', $event)
                ->with('error', 'You are not authorized to edit this event.');
        }
        
        $tags = \App\Models\Tag::orderBy('name')->get();
        $eventTags = $event->tags()->pluck('tags.id')->toArray();
        
        return view('events.edit', compact('event', 'tags', 'eventTags'));
    }

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
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'curriculum_title' => 'nullable|string|max:255',
            'curriculum_description' => 'nullable|string|max:1000',
            'curriculum_file' => 'nullable|file|mimes:pdf|max:10240',
            'remove_curriculum' => 'nullable|boolean',
        ]);

        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        $event->tags()->sync($request->input('tags', []));

        if ($request->boolean('remove_curriculum') && $event->curriculum) {
            if ($event->curriculum->file_path) {
                Storage::disk('public')->delete($event->curriculum->file_path);
            }
            $event->curriculum->delete();
        }

        if ($request->filled('curriculum_title') && $request->filled('curriculum_description')) {
            $curriculum = $event->curriculum ?? new Curriculum();
            $curriculum->event_id = $event->id;
            $curriculum->user_id = Auth::id();
            $curriculum->title = $request->curriculum_title;
            $curriculum->description = $request->curriculum_description;

            if ($request->hasFile('curriculum_file')) {
                if ($curriculum->file_path) {
                    Storage::disk('public')->delete($curriculum->file_path);
                }
                $curriculum->file_path = $request->file('curriculum_file')->store('curricula', 'public');
            }

            $curriculum->save();
        }

        return redirect()->route('events.show', $event)->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if (Auth::id() !== $event->creator_id) {
            return redirect()->route('events.show', $event)->with('error', 'You are not authorized to delete this event.');
        }

        $event->tags()->detach();

        if ($event->curriculum) {
            if ($event->curriculum->file_path) {
                Storage::disk('public')->delete($event->curriculum->file_path);
            }
            $event->curriculum->delete();
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    public function export(Event $event)
    {
        $icsContent = $this->calendarService->generateEventIcs($event);

        return response($icsContent)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="event-' . $event->id . '.ics"');
    }

    public function chat(Event $event)
    {
        return view('events.event-chatroom', compact('event'));
    }
}
