<x-app-layout>
    <div class="relative w-full h-[500px] bg-black">
        <div class="absolute inset-0 w-full h-full">
            <img id="backgroundImage" src="https://image.tmdb.org/t/p/original{{ $movies['results'][0]['backdrop_path'] ?? '' }}" 
            alt="Featured Movie" class="w-full h-full object-cover opacity-50 transition-opacity duration-1000">
        </div>
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-6">
            <h1 class="text-5xl font-bold text-white drop-shadow-lg">The Best Movie Recommendation Sites</h1>
            <p class="text-lg text-gray-300 max-w-2xl mt-4">
                Discover the latest blockbuster movies, classic favorites, and exclusive shows on demand.
            </p>
            <a href="{{ url('/popular') }}" 
                class="mt-6 px-6 py-3 bg-red-600 text-white text-lg font-semibold rounded-lg shadow-lg hover:bg-red-700 transition duration-200">
                Start Search Now
            </a>
        </div>
    </div>

    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-black">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl font-semibold text-center mb-8 text-white">Popular Movies</h1>
            @if (!empty($movies['results']))
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($movies['results'] as $movie)
                        <a href="{{ route('movies.detail', $movie['id']) }}" class="block bg-gray-900 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition duration-300">
                            <img class="w-full h-80 object-cover" src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-white">{{ $movie['title'] }}</h3>
                                <p class="text-sm text-gray-400"><strong>Overview:</strong> {{ Str::limit($movie['overview'], 100, '...') }}</p>
                                <p class="text-sm text-gray-400"><strong>Release Date:</strong> {{ $movie['release_date'] }}</p>
                                <p class="text-sm text-gray-400"><strong>Rating:</strong> {{ $movie['vote_average'] }}/10</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-red-600 text-center">No movies found.</p>
            @endif

            <!-- Pagination Section -->
            @if (isset($movies['page']) && isset($movies['total_pages']))
                <div class="flex justify-center items-center mt-8 text-white">
                    <p class="text-lg mr-4">Page {{ $movies['page'] }} of {{ $movies['total_pages'] }}</p>
                    @if ($movies['page'] < $movies['total_pages'])
                        <a href="{{ url('/dashboard?page=' . ($movies['page'] + 1)) }}" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            Next Page
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="bg-black py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <!-- Left Section: Welcome Message & Movie Grid -->
            <div>
                <h1 class="text-4xl font-bold text-white">Welcome to our best website!</h1>
                <p class="text-gray-300 mt-4">We're here to help you with any problems you may be having with our product.</p>
                
                <div class="grid grid-cols-3 gap-4 mt-6">
                    @foreach (array_slice($movies['results'], 0, 6) as $movie)
                        <img src="https://image.tmdb.org/t/p/w200{{ $movie['poster_path'] }}" 
                            alt="{{ $movie['title'] }}" 
                            class="w-full h-auto rounded-lg shadow-md transform hover:scale-105 transition duration-300">
                    @endforeach
                </div>
            </div>
            
            <!-- Right Section: Discussion Forum -->
            <div class="bg-gray-900 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-white mb-4">Discussion Forum</h2>
                @auth
                    <div class="space-y-4">
                        <textarea id="comment" placeholder="Write your comment..."
                            class="p-3 bg-gray-800 text-white rounded w-full h-24 focus:ring focus:ring-red-500"></textarea>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="anonymous" class="h-5 w-5 text-red-600">
                            <label for="anonymous" class="text-gray-300">Post as Anonymous</label>
                        </div>
                        <button onclick="postComment()"
                            class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition duration-300">
                            Post Comment
                        </button>
                    </div>
                @else
                    <p class="text-gray-400">You must be <a href="{{ route('login') }}" class="text-red-500">logged in</a> to comment.</p>
                @endauth    
                <div id="comments-section"
                class="mt-6 space-y-4 max-h-96 overflow-y-auto p-4 bg-gray-900 rounded-lg shadow-inner scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-700">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Free Trial Section -->
    <div class="relative bg-black py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <h2 class="text-4xl font-bold text-white">Ready To Explore ?</h2>
            <p class="text-gray-200 mt-4 max-w-2xl mx-auto">
                Come explore your favorite films and discover the best films ever made!
            </p>
            <a href="#" class="mt-6 inline-block bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 transition duration-300">Let's Go</a>
        </div>
        <div class="absolute inset-0 rounded-xl">
            <img src="https://image.tmdb.org/t/p/original{{ $movies['results'][0]['backdrop_path'] ?? '' }}" 
                alt="Featured Movie" class="w-full h-full object-cover opacity-50 p-7">
        </div>
    </div>
    


    <script>
        function fetchComments() {
            fetch('{{ route("discussion.fetch") }}')
                .then(response => response.json())
                .then(data => {
                    let commentsHTML = '';
                    data.forEach(comment => {
                        let userInitial = comment.user.charAt(0).toUpperCase(); 
                        commentsHTML += `
                        <div class="flex items-start space-x-4 bg-gray-800 p-4 rounded-xl shadow-md border border-gray-700 
                                    hover:shadow-lg hover:scale-105 transition-transform duration-300">
                            <!-- Avatar -->
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-red-600 text-white font-bold">
                                ${userInitial}
                            </div>
                        
                            <!-- Comment Body -->
                            <div class="flex-1">
                                <h3 class="text-white font-semibold text-lg">${comment.user}</h3>
                                <p class="text-gray-200 mt-1 text-sm leading-relaxed">${comment.comment}</p>
                                <p class="text-gray-500 text-xs mt-2">${comment.created_at}</p>
                            </div>
                        </div>`;
                    });
                document.getElementById('comments-section').innerHTML = commentsHTML;
                })
                .catch(error => console.error('Error fetching comments:', error));
        }

        function postComment() {
            let comment = document.getElementById('comment').value.trim();
            let anonymous = document.getElementById('anonymous').checked; 
        
            if (!comment) {
                alert('Comment cannot be empty');
                return;
            }

        fetch('/discussion/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: "same-origin",
            body: JSON.stringify({ comment: comment, anonymous: anonymous }) 
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('comment').value = '';
                document.getElementById('anonymous').checked = false;
                fetchComments();
            } else {
                console.error('Server error:', data);
            }
        })
        .catch(error => console.error('Error posting comment:', error));
        }
        
        fetchComments(); 

        document.addEventListener("DOMContentLoaded", function () {
            const movies = @json($movies['results']);
            const images = movies.map(movie => movie.backdrop_path ? `https://image.tmdb.org/t/p/original${movie.backdrop_path}` : null).filter(url => url);
            
            if (images.length === 0) return;
            
            const bgImage = document.getElementById("backgroundImage");
            
            function changeBackground() {
                const randomIndex = Math.floor(Math.random() * images.length);
                bgImage.style.transition = "opacity 1s";
                bgImage.style.opacity = 0; 
                
                setTimeout(() => {
                    bgImage.src = images[randomIndex];
                    bgImage.style.opacity = 0.5; 
                }, 1000);
            }
            
            setInterval(changeBackground, 5000); 
        });
    </script>
    
</x-app-layout>
