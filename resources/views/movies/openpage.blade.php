
@section('title', 'open page')
<div class="relative w-full h-[500px] bg-black">
        <div class="absolute inset-0">
            <img src="https://image.tmdb.org/t/p/original{{ $movies['results'][0]['backdrop_path'] ?? '' }}" 
                alt="Featured Movie" class="w-full h-full object-cover opacity-50">
    <div class="bg-black text-white min-h-screen">
        <div class="container mx-auto p-4">
            <div class="relative w-full h-[500px]">
                <img src="/images/kantara.jpg" alt="Kantara" class="w-full h-full object-cover rounded-lg">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center p-8">
                    <h1 class="text-4xl font-bold">Kantara</h1>
                    <p class="mt-2">A fiery young man clashes with an unflinching forest officer in a south Indian village where spirituality, fate and folklore rule the lands.</p>
                    <button class="mt-4 bg-red-600 px-4 py-2 rounded text-white font-semibold">▶ Play Now</button>
                </div>
            </div>
            
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold">Description</h2>
                    <p class="mt-2">A fiery young man clashes with an unflinching forest officer in a south Indian village where spirituality, fate and folklore rule the lands.</p>
                    
                    <h2 class="mt-6 text-xl font-semibold">Cast</h2>
                    <div class="flex space-x-4 mt-4">
                        @foreach ($cast as $actor)
                            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center">
                                <img src="{{ $actor['image'] }}" alt="{{ $actor['name'] }}" class="rounded-full">
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div>
                    <h2 class="text-xl font-semibold">Released Year</h2>
                    <p class="mt-2">2022</p>
                    
                    <h2 class="mt-6 text-xl font-semibold">Available Languages</h2>
                    <p class="mt-2">English, Hindi, Tamil, Telugu, Kannada</p>
                    
                    <h2 class="mt-6 text-xl font-semibold">Ratings</h2>
                    <p class="mt-2">IMDb: 4.5 | StreamVibe: 4.4</p>
                    
                    <h2 class="mt-6 text-xl font-semibold">Genres</h2>
                    <p class="mt-2">Action, Adventure</p>
                    
                    <h2 class="mt-6 text-xl font-semibold">Director</h2>
                    <p class="mt-2">Rishab Shetty</p>
                    
                    <h2 class="mt-6 text-xl font-semibold">Music</h2>
                    <p class="mt-2">B. Ajaneesh Loknath</p>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-semibold">Reviews</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    @foreach ($reviews as $review)
                        <div class="p-4 bg-gray-900 rounded-lg">
                            <h3 class="font-semibold">{{ $review['name'] }}</h3>
                            <p class="text-sm text-gray-400">From {{ $review['location'] }}</p>
                            <p class="mt-2">{{ $review['content'] }}</p>
                            <p class="mt-2 text-yellow-400">{{ str_repeat('★', $review['rating']) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
