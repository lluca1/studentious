<nav x-data="{ open: false }" class="nav-wrapper">
    <div class="nav-container">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="nav-logo">
                    <img src="{{ asset("/images/nav-logo.png") }}" alt="Studentious Logo" class="object-cover object-center max-h-12">
                </a>
            </div>

            <!-- Links -->
            @auth
                <div class="hidden md:flex space-x-6 items-center">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.index') ? 'nav-link-active' : '' }}">
                        Events
                    </a>
                    <a href="{{ route('events.create') }}" class="nav-link {{ request()->routeIs('events.create') ? 'nav-link-active' : '' }}">
                        Create Event
                    </a>
                </div>
            @endauth

            <!-- Auth Buttons or Dropdown -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="nav-user-btn">
                            {{ Auth::user()->name }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="nav-dropdown" x-cloak>
                            <a href="{{ route('profile.edit') }}" class="nav-dropdown-item">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-dropdown-item">Log Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-auth-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-auth-link nav-auth-register">Register</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="open = ! open" class="nav-toggle">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" class="md:hidden mt-2 space-y-2">
            @auth
                <a href="{{ route('dashboard') }}" class="nav-link-mobile">Dashboard</a>
                <a href="{{ route('events.index') }}" class="nav-link-mobile">Events</a>
                <a href="{{ route('events.create') }}" class="nav-link-mobile">Create Event</a>
                <a href="{{ route('profile.edit') }}" class="nav-link-mobile">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="nav-dropdown-form px-4">
                    @csrf
                    <button type="submit" class="nav-link-mobile text-left w-full">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link-mobile">Login</a>
                <a href="{{ route('register') }}" class="nav-link-mobile">Register</a>
            @endauth
        </div>
    </div>
</nav>
