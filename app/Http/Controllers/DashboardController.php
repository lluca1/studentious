<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
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
}
