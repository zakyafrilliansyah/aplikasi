<x-app-layout>
    @section('title', 'Movies by ' . $movies['cast'][0]['name'])

    <div class="container mx-auto p-4 text-white ">
        <h1 class="text-4xl font-semibold text-center mb-8">Movies by {{ $movies['cast'][0]['name'] }}</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($movies['cast'] as $movie)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img 
                        src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" 
                        alt="{{ $movie['title'] }}" 
                        class="w-full object-cover"
                    >
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-red-500">{{ $movie['title'] }}</h3>
                        <p class="text-sm text-gray-600"><strong>Character:</strong> {{ $movie['character'] ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600"><strong>Release Date:</strong> {{ $movie['release_date'] ?? 'N/A' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
