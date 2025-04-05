<?php

namespace App\Http\Controllers;

use App\Services\CalendarService;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * Display the dashboard with the user's next upcoming event.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        
        $nextEvent = $user->events()
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->first();
            
        return view('dashboard', compact('nextEvent'));
    }
    
    /**
     * Export all user's events as a single ICS file.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function exportAllEvents()
    {
        $user = auth()->user();
        
        $events = $user->events()
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();
            
        if ($events->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'You have no upcoming events to export.');
        }
        
        $icsContent = $this->calendarService->generateEventsIcs($events);

        return response($icsContent)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="my-events.ics"');
    }
}
