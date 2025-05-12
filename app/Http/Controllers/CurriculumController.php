<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurriculumController extends Controller
{
    public function destroy(Curriculum $curriculum)
    {
        if (auth()->id() !== $curriculum->user_id && auth()->id() !== $curriculum->event->creator_id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this curriculum.');
        }

        if ($curriculum->file_path) {
            Storage::disk('public')->delete($curriculum->file_path);
        }

        $curriculum->delete();

        return redirect()->back()->with('message', 'Curriculum deleted successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_id' => 'required|exists:events,id',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        $filePath = $request->hasFile('file') ? $request->file('file')->store('curricula', 'public') : null;

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