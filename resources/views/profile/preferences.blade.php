@extends('layouts.app')

@section('title', 'Tag Preferences')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        Tag Preferences
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Select tags that interest you. You'll receive personalized event recommendations based on your preferences.
                    </p>
                </header>

                @if (session('status') === 'preferences-updated')
                    <div class="mt-4 p-4 bg-green-50 rounded-md">
                        <p class="text-sm text-green-600">Your preferences have been updated.</p>
                    </div>
                @endif

                <form method="post" action="{{ route('profile.update-preferences') }}" class="mt-6 space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($tags as $tag)
                            <div class="flex items-center space-x-2">
                                <input 
                                    type="checkbox" 
                                    id="tag-{{ $tag->id }}" 
                                    name="tags[]" 
                                    value="{{ $tag->id }}"
                                    @checked(in_array($tag->id, $userTagIds))
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                <label for="tag-{{ $tag->id }}" class="text-sm text-gray-700">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection