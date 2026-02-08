<x-app-layout>
    @section('title', $person['name'] . ' - Actor Details')

    <div class="container bg-black mx-auto px-6 py-8 text-white">
        <div class="max-w-8xl mx-auto bg-gray-800 shadow-lg rounded-xl overflow-hidden p-6 text-white">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <div class="relative flex flex-col items-center pt-20">
                    <div class="absolute top-0 w-full text-center py-5 z-10">
                        <h1 class="text-3xl md:text-5xl font-bold text-white">{{ $person['name'] }}</h1>
                    </div>
                    <img src="https://image.tmdb.org/t/p/w500{{ $person['profile_path'] }}" alt="{{ $person['name'] }}" 
                        class="rounded-lg shadow-md w-48 md:w-72 h-auto transition-transform transform hover:scale-105 mt-16">
                </div>
                <!-- Informasi Aktor -->
                <div class="md:col-span-2">
                    <h2 class="text-xl md:text-2xl font-semibold mb-3">Biography</h2>
                    <div class="relative">
                        <p id="biography" class="text-base md:text-lg text-gray-400 leading-relaxed overflow-hidden sm:max-h-24 transition-all duration-300">
                            {{ $person['biography'] ?: 'Biography not available.' }}
                        </p>
                        <div id="fadeOverlay" class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-t hidden sm:block"></div>
                    </div>
                    <button id="readMoreBtn" class="text-blue-600 hover:underline font-semibold mt-2 hidden sm:inline-block" onclick="toggleBiography()">
                        Read More
                    </button>

                    <div class="mt-6 p-5 md:p-6 rounded-lg shadow-xl">
                        <h2 class="text-xl md:text-2xl font-semibold mb-4">Personal Info</h2>
                        <ul class="text-base md:text-lg space-y-2 text-gray-400">
                            <li><strong>Also Known As:</strong> {{ $person['also_known_as'][0] ?? 'N/A' }}</li>
                            <li><strong>Birthday:</strong> {{ $person['birthday'] ?? 'N/A' }}</li>
                            <li><strong>Place of Birth:</strong> {{ $person['place_of_birth'] ?? 'N/A' }}</li>
                            <li><strong>Popularity:</strong> {{ number_format($person['popularity'], 1) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleBiography() {
                const bio = document.getElementById("biography");
                const btn = document.getElementById("readMoreBtn");
                const overlay = document.getElementById("fadeOverlay");

                if (bio.classList.contains("sm:max-h-24")) {
                    bio.classList.remove("sm:max-h-24");
                    overlay.classList.add("hidden");
                    btn.innerText = "Read Less";
                } else {
                    bio.classList.add("sm:max-h-24");
                    overlay.classList.remove("hidden");
                    btn.innerText = "Read More";
                }
            }

            document.addEventListener("DOMContentLoaded", function() {
                const bio = document.getElementById("biography");
                const btn = document.getElementById("readMoreBtn");
                const overlay = document.getElementById("fadeOverlay");

                if (bio.scrollHeight > bio.clientHeight) {
                    btn.classList.remove("hidden");
                    overlay.classList.remove("hidden");
                }
            });
        </script>

        <!-- Bagian "Known For" -->
        @if (isset($person['movie_credits']['cast']) && !empty($person['movie_credits']['cast']))
            <div class="mt-12">
                <h2 class="text-2xl font-semibold mb-4 text-white">Known For</h2>
                
                <div class="overflow-x-auto">
                    <div class="flex space-x-6 p-2">
                        @foreach ($person['movie_credits']['cast'] as $movie)
                            <div class="flex-none w-44 bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition duration-300">
                                <a href="{{ route('movies.detail', $movie['id']) }}">
                                    <img class="w-full h-64 object-cover" 
                                        src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] ?? '/default.jpg' }}" 
                                        alt="{{ $movie['title'] }}">
                                    <div class="p-3 text-center">
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $movie['title'] }}</h3>
                                        <p class="text-xs text-gray-600">
                                            {{ !empty($movie['release_date']) ? date('Y', strtotime($movie['release_date'])) : 'N/A' }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Tombol Back -->
        <div class="fixed bottom-4 right-4">
            <button 
                onclick="window.history.back()" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300"
            >
                Back
            </button>
        </div>
    </div>
</x-app-layout>
