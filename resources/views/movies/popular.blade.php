<x-app-layout>
    @section('title', 'Popular Movies')

    <div class="py-12 bg-black text-white">
        {{-- -----------Trending Movies------------- --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-12">
            <h2 class="text-3xl font-bold mb-6">Trending Now</h2>
            <div x-data="{ scrollAmount: 300 }" class="relative">
                <div class="flex space-x-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory" x-ref="scrollContainer">
                    @foreach($trendingMovies as $movie)
                        <a href="{{ route('movies.detail', $movie['id']) }}" class="w-52 bg-gray-900 rounded-lg p-4 shadow-md snap-start flex-shrink-0 block">
                            <div class="relative w-full h-72 bg-gray-700 rounded-lg overflow-hidden">
                                <img src="https://image.tmdb.org/t/p/w300/{{ $movie['poster_path'] ?? '' }}" 
                                    alt="{{ $movie['title'] ?? 'Unknown Title' }}" class="w-full h-full object-cover object-center">
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 p-2 text-sm text-white">
                                    <p class="truncate">{{ $movie['title'] ?? 'Unknown Title' }}</p>
                                </div>
                            </div>
                            <div class="mt-3 text-sm text-gray-300 flex justify-between">
                                <span>{{ $movie['runtime'] ?? 'N/A' }} min</span>
                                <span><i class="fas fa-eye"></i> {{ $movie['popularity'] ?? '0' }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="absolute top-1/2 transform -translate-y-1/2 w-full flex justify-between px-4">
                    <button @click="$refs.scrollContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' })"
                            class="bg-gray-800 p-2 rounded-full shadow-md text-white">&larr;</button>
                    <button @click="$refs.scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' })"
                            class="bg-gray-800 p-2 rounded-full shadow-md text-white">&rarr;</button>
                </div>
            </div>
        </div>
        {{-- -----------Genre Movies------------- --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-12" x-data="{ selectedGenre: null, selectedMovies: [] }">
            <h2 class="text-3xl font-bold mb-6">Our Genres</h2>
            <div x-data="{ scrollAmount: 300 }" class="relative">
                <div class="flex space-x-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory pb-4" x-ref="scrollContainer">
                    @foreach($moviesByGenre as $genre => $movies)
                        <div class="w-52 sm:w-56 md:w-64 min-w-[12rem] bg-gray-900 rounded-lg p-4 shadow-md snap-start cursor-pointer"
                            @click='selectedGenre = @json($genre); selectedMovies = @json($movies)'>
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                @foreach($movies as $index => $movie)
                                    @if($index < 4)
                                        <div class="relative w-full h-32 sm:h-36 md:h-40 bg-gray-700 rounded-lg overflow-hidden">
                                            <img src="https://image.tmdb.org/t/p/w200/{{ $movie['poster_path'] ?? '' }}" 
                                                alt="{{ $movie['title'] ?? 'Unknown Title' }}" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="flex justify-between items-center">
                                <h3 class="text-sm sm:text-base md:text-lg font-semibold">{{ $genre }}</h3>
                                <span class="text-red-500">&rarr;</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Modal Genre Movies -->
            <div x-show="selectedGenre" @click.away="selectedGenre = null"
                class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 sm:p-6 z-50" x-cloak>
                <div class="bg-gray-900 p-4 sm:p-6 rounded-lg shadow-lg max-w-5xl w-full relative">
                    <button @click="selectedGenre = null"
                        class="absolute top-3 right-3 text-white text-2xl bg-gray-700 p-2 rounded-full shadow-md hover:bg-gray-600 transition">
                        &times;
                    </button>
                    <h2 class="text-xl sm:text-2xl font-bold mb-4 text-white text-center">
                        Movies in <span x-text="selectedGenre"></span>
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <template x-for="movie in selectedMovies" :key="movie.id">
                            <a :href="'{{ route('movies.detail', 0) }}'.replace('/0', '/' + movie.id)"
                                class="bg-gray-800 rounded-lg p-2 hover:bg-gray-700 transition">
                                <img :src="'https://image.tmdb.org/t/p/w200/' + movie.poster_path" 
                                    :alt="movie.title" class="w-full h-auto rounded-md">
                                <p class="text-xs sm:text-sm text-white mt-2 text-center" x-text="movie.title"></p>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        {{--------------Must-Watch Movies----------------}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-12">
            <h2 class="text-3xl font-bold mb-6">Must-Watch Movies</h2>
            <div x-data="{ scrollAmount: 300 }" class="relative">
                <div class="flex space-x-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory" x-ref="scrollContainer">
                    @foreach($mustWatchMovies as $movie)
                        <a href="{{ route('movies.detail', $movie['id']) }}" class="w-52 bg-gray-900 rounded-lg p-4 shadow-md snap-start flex-shrink-0 block">
                            <div class="relative w-full h-72 bg-gray-700 rounded-lg overflow-hidden">
                                <img src="https://image.tmdb.org/t/p/w300/{{ $movie['poster_path'] ?? '' }}" 
                                    alt="{{ $movie['title'] ?? 'Unknown Title' }}" class="w-full h-full object-cover object-center">
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 p-2 text-sm text-white">
                                    <p class="truncate">{{ $movie['title'] ?? 'Unknown Title' }}</p>
                                </div>
                            </div>
                            <div class="mt-3 text-sm text-gray-300 flex justify-between">
                                <span>{{ $movie['runtime'] ?? 'N/A' }} min</span>
                                <span><i class="fas fa-star text-yellow-500"></i> {{ number_format($movie['vote_average'], 1) }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>


        {{-- ---------------FITUR SIDE BAR FOR SORT AND SERCH--------------- --}}
        {{-- <div x-data="{ openSidebar: false }" class="relative">
            <button @click="openSidebar = true"
                class="fixed top-20 left-5 z-50 bg-gray-700 text-white px-4 py-2 rounded-lg shadow-md">
                ☰ Filter & Sort
            </button>
            <div x-show="openSidebar"
                class="fixed inset-0 bg-black bg-opacity-50 z-40"
                @click="openSidebar = false"
                x-transition.opacity
                x-cloak>
            </div>

            
            <!-- Sidebar -->
            <div x-show="openSidebar"
                class="fixed top-0 left-0 w-72 h-full bg-gray-900 text-white p-6 z-50 shadow-lg transform transition-transform duration-300 ease-in-out"
                :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
                @keydown.window.escape="openSidebar = false"
                x-cloak>
                
                <!-- Tombol untuk menutup sidebar -->
                <button @click="openSidebar = false"
                    class="absolute top-3 right-3 text-xl">
                    &times;
                </button>

                <h3 class="font-semibold text-lg mb-4">Filter & Sort</h3>
                <form action="{{ route('movies.filter') }}" method="GET" class="space-y-4">
                    <label class="block">
                        <span class="text-gray-300">Country:</span>
                        <select name="certification_country" class="mt-1 block w-full border rounded p-2 text-black">
                            <option value="">All Countries</option>
                            <option value="US">United States</option>
                            <option value="GB">United Kingdom</option>
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-gray-300">Rating:</span>
                        <select name="certification" class="mt-1 block w-full border rounded p-2 text-black">
                            <option value="">All Ratings</option>
                            <option value="G">G</option>
                            <option value="PG">PG</option>
                            <option value="PG-13">PG-13</option>
                            <option value="R">R</option>
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-gray-300">Sort By:</span>
                        <select name="sort_by" class="mt-1 block w-full border rounded p-2 text-black">
                            <option value="popularity.desc">Popularity</option>
                            <option value="vote_average.desc">Rating</option>
                            <option value="release_date.desc">Release Date</option>
                        </select>
                    </label>

                    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>
         --}}

        {{--------------Movies ----------------}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-12">
            @if(isset($allMovies) && count($allMovies) > 0)
            <h2 class="text-3xl font-bold mb-6">Movies</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($allMovies as $movie)
                    <a href="{{ route('movies.detail', $movie['id']) }}" class="bg-gray-900 rounded-lg p-4 shadow-md">
                        <div class="relative w-full h-72 bg-gray-700 rounded-lg overflow-hidden">
                            <img src="https://image.tmdb.org/t/p/w300/{{ $movie['poster_path'] ?? '' }}" 
                                alt="{{ $movie['title'] ?? 'Unknown Title' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="mt-3 text-sm text-gray-300">
                            <p class="font-semibold truncate">{{ $movie['title'] ?? 'Unknown Title' }}</p>
                            <span>{{ $movie['release_date'] ?? 'N/A' }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
            @endif
        </div>
        <!-- Pagination Section -->
        @if (isset($allMoviesResponse['page']) && isset($allMoviesResponse['total_pages']))
            <div class="flex justify-center items-center mt-8 text-white">
                <p class="text-lg mr-4">Page {{ $allMoviesResponse['page'] }} of {{ $allMoviesResponse['total_pages'] }}</p>
                @if ($allMoviesResponse['page'] < $allMoviesResponse['total_pages'])
                    <a href="{{ url('/popular/filter?' . http_build_query(request()->all() + ['page' => $allMoviesResponse['page'] + 1])) }}" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        Next Page
                    </a>
                @endif
            </div>
        @endif
        

    </div>
</x-app-layout>
