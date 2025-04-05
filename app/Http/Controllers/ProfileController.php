<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\User; // ✅ Add this line!

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = Auth::user();
        return view('profile.edit', ['user' => $user]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'username' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'twitter' => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update($request->only(['name', 'email', 'username', 'bio', 'twitter']));

        return back()->with('status', 'Profile updated successfully!');
    }

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
}
