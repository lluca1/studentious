<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function preferences()
    {
        $user = auth()->user();
        $tags = Tag::orderBy('name')->get();
        $userTagIds = $user->tags()->pluck('tags.id')->toArray();
        
        return view('profile.preferences', [
            'user' => $user,
            'tags' => $tags,
            'userTagIds' => $userTagIds
        ]);
    }

    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);
        
        $user = auth()->user();
        
        $user->tags()->sync($request->tags ?? []);
        
        return redirect()->route('profile.preferences')
            ->with('status', 'preferences-updated');
    }
}
