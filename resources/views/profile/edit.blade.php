@extends('layouts.app')

@section('title', 'Edit Profile')

@section('header')
    <h2 class="studentious-heading">Profile</h2>
@endsection

@section('content')
<div class="studentious-wrapper">
    <div class="studentious-container">
        @if (session('status'))
            <div class="studentious-alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="studentious-card studentious-inner">
            <h3 class="text-xl font-bold mb-4">Update Profile</h3>
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div class="studentious-field">
                    <label class="studentious-label" for="name">Full Name</label>
                    <input class="studentious-input" type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required />
                </div>

                <div class="studentious-field">
                    <label class="studentious-label" for="username">Username</label>
                    <input class="studentious-input" type="text" name="username" id="username" value="{{ old('username', $user->username ?? '') }}" />
                </div>

                <div class="studentious-field">
                    <label class="studentious-label" for="email">Email</label>
                    <input class="studentious-input" type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required />
                </div>

                <div class="studentious-field">
                    <label class="studentious-label" for="bio">Bio</label>
                    <textarea class="studentious-input" name="bio" id="bio" rows="3">{{ old('bio', $user->bio ?? '') }}</textarea>
                </div>

                <div class="studentious-field">
                    <label class="studentious-label" for="twitter">Twitter</label>
                    <input class="studentious-input" type="text" name="twitter" id="twitter" value="{{ old('twitter', $user->twitter ?? '') }}" />
                </div>

                <div class="text-right">
                    <button type="submit" class="studentious-button">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <div class="studentious-card studentious-inner mt-6 bg-red-50">
            <h3 class="text-xl font-semibold text-red-700 mb-2">Delete Account</h3>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="studentious-field">
                    <label class="studentious-label" for="password">Confirm Password</label>
                    <input class="studentious-input" type="password" name="password" required />
                </div>

                <button type="submit" class="studentious-button bg-red-600 hover:bg-red-700">
                    Delete Account
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
