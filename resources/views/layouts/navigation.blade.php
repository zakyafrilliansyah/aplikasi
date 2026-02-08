<nav id="navbar" x-data="{ open: false }" class="fixed w-full z-10 top-0 left-0 bg-transparent transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center ">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/LOGOS.png') }}" alt="Kamar FILM Logo" class="w-24 h-24" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('popular')" :active="request()->routeIs('popular')">
                        {{ __('Movie') }}
                    </x-nav-link>
                    <x-nav-link :href="route('people')" :active="request()->routeIs('people')">
                        {{ __('People') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="flex items-center space-x-4 relative">
                <!-- Search Component -->
                <div x-data="{ searchOpen: false }" class="relative">
                    <!-- Search Button -->
                    <button @click="searchOpen = !searchOpen" 
                        class="p-3 bg-gray-900 text-white rounded-full hover:bg-gray-700 transition duration-300 focus:outline-none shadow-md flex items-center relative z-20">
                        🔍
                    </button>
            
                    <!-- Search Form -->
                    <form id="searchForm" action="{{ route('movies.search') }}" method="GET" 
                    x-show="searchOpen" @click.away="searchOpen = false"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90"
                    class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-lg rounded-full border border-gray-300 dark:border-gray-700 
                    overflow-hidden transition-all w-48 sm:w-64 z-50">
                    
                    <div class="flex items-center">
                        <input type="text" name="query" placeholder="Search movies..."
                            class="w-full p-3 bg-transparent text-gray-900 dark:text-white focus:outline-none placeholder-gray-400"
                            x-ref="searchInput" @keydown.escape.window="searchOpen = false"
                            x-init="$watch('searchOpen', value => { if (value) $nextTick(() => $refs.searchInput.focus()) })">
                    
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-3 transition duration-300">
                            🔎
                        </button>
                    </div>
                </form>
                </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="w-10 h-10 rounded-full">
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" 
                        class="px-4 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 transition duration-150">
                            {{ __('Login') }}
                        </a>
                    
                        <a href="{{ route('register') }}" 
                        class="px-4 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-700 transition duration-150">
                            {{ __('Register') }}
                        </a>
                    </div>
                    
                @endauth
            </div>
            <!-- Hamburger Menu (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('popular')" :active="request()->routeIs('popular')">
                {{ __('Movie') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('people')" :active="request()->routeIs('people')">
                {{ __('People') }}
            </x-responsive-nav-link>
        </div>
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 flex items-center">
                @auth
                    <img src="{{ optional(Auth::user())->profile_picture ?? asset('images/default-profile.png') }}" alt="Profile Picture" class="w-10 h-10 rounded-full">
                    <div class="ml-3">
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">
                            {{ Auth::user()->email }}
                        </div>
                    </div>
                @else
                    <div class="flex items-center w-full px-4 py-2 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 dark:bg-yellow-900 dark:border-yellow-600 dark:text-yellow-300 rounded-md">
                        <svg class="w-6 h-6 mr-2 text-yellow-500 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 18a1 1 0 100-2 1 1 0 000 2zm0-14a7 7 0 11-7 7 7 7 0 017-7z" />
                        </svg>
                        <span class="font-medium">You are browsing as a guest</span>
                    </div>
                @endauth
            </div>
            <div class="mt-3 space-y-1">
                @auth
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @else
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const navbar = document.getElementById("navbar");

    window.addEventListener("scroll", function() {
        console.log("Scroll detected:", window.scrollY);
        if (window.scrollY > 90) {
            navbar.classList.add("backdrop-blur-md", "bg-gray-900/50", "shadow-md", "rounded-b-xl");
        } else {
            navbar.classList.remove("backdrop-blur-md", "bg-gray-900/50", "shadow-md", "rounded-b-xl");
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const searchIcon = document.getElementById("searchIcon");
    const searchForm = document.getElementById("searchForm");

    searchIcon.addEventListener("click", function(event) {
        event.stopPropagation();
        searchForm.classList.toggle("hidden");
    
        if (!searchForm.classList.contains("hidden")) {
            searchIcon.classList.add("hidden");
        }
    });

    document.addEventListener("click", function(event) {
        if (!searchForm.contains(event.target) && event.target !== searchIcon) {
            searchForm.classList.add("hidden");
            searchIcon.classList.remove("hidden");
        }
    });
});

</script>