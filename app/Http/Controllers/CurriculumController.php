<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_id' => 'required|exists:events,id',
            'file' => 'nullable|mimes:pdf|max:10240', // max 10MB
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('curricula', 'public');
        }

        Curriculum::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'event_id' => $validated['event_id'],
            'user_id' => auth()->id(),
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Curriculum submitted successfully!');
    }
}
