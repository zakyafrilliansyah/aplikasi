<x-app-layout>
    @section('title', 'My Watchlist')
    <div class="bg-black text-white min-h-screen">
        <div class="container mx-auto max-w-7xl p-6">
            <h1 class="text-3xl font-bold mb-6">My Watchlist</h1>
            
            @if($movies->isEmpty())
                <p class="text-gray-400">Your watchlist is empty.</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($movies as $movie)
                        <div class="bg-gray-900 p-4 rounded-lg shadow-lg relative">
                            <img src="https://image.tmdb.org/t/p/w500/{{ $movie->poster_path }}" 
                                alt="{{ $movie->title }}" 
                                class="w-full h-auto object-cover rounded-lg">
                            <h2 class="text-lg font-semibold mt-2">{{ $movie->title }}</h2>
                            <p class="text-gray-400 text-sm">Release Date: {{ $movie->release_date }}</p>
                            
                            <!-- Remove from Watchlist Button -->
                            <form action="{{ route('watchlist.destroy', $movie->id) }}" method="POST" class="absolute top-2 right-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm">Remove</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
