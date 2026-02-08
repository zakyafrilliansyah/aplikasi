<x-app-layout>
    @section('title', 'Search Results')

    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-black">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl font-semibold text-center mb-8 text-white">
                Search Results for: "{{ $query }}"
            </h1>
            @if (empty($movies['results']))
                <p class="text-red-600 text-center">No movies found for "{{ $query }}".</p>
            @else
                <h2 class="text-2xl font-medium mb-6 text-white">Movies Matching Your Search</h2>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach ($movies['results'] as $movie)
                        <a href="{{ route('movies.detail', $movie['id']) }}" 
                        class="block bg-gray-900 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition duration-300">
                            <img class="w-full h-[450px] object-cover" 
                                src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" 
                                alt="{{ $movie['title'] }}">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-red-500">{{ $movie['title'] }}</h3>
                                <p class="text-sm text-gray-400"><strong>Release Date:</strong> {{ $movie['release_date'] ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-400"><strong>Rating:</strong> ⭐ {{ $movie['vote_average'] ?? 'N/A' }}/10</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
            <!-- Pagination Section -->
            <div class="flex justify-center items-center mt-8">
                <p class="text-lg text-white mr-4">Page {{ $movies['page'] }} of {{ $movies['total_pages'] }}</p>
                <div class="flex space-x-4">
                    @if ($movies['page'] > 1)
                        <a href="{{ route('movies.search', ['query' => $query, 'page' => $movies['page'] - 1]) }}" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            Previous Page
                        </a>
                    @endif
                    @if ($movies['page'] < $movies['total_pages'])
                        <a href="{{ route('movies.search', ['query' => $query, 'page' => $movies['page'] + 1]) }}" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            Next Page
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
