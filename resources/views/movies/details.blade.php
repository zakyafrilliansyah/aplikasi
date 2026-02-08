<x-app-layout>
    @section('title', $movie['title'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <div class="relative w-full h-[500px] bg-black">
        <div class="absolute inset-0">
            <img src="https://image.tmdb.org/t/p/original{{ $movie['backdrop_path'] ?? '' }}" 
                alt="{{ $movie['title'] }}" 
                class="w-full h-full object-cover opacity-60">
        </div>
    </div>
    <div class="bg-black text-white min-h-screen">
        <div class="container mx-auto max-w-7xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Poster & Basic Info -->
                <div class="md:col-span-1" x-data="{ showTrailer: false }">
                    <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" 
                        alt="{{ $movie['title'] }}" 
                        class="w-full h-auto object-cover rounded-lg shadow-lg">
                    
                    <!-- Button Play Now -->
                    <button @click="showTrailer = true" 
                        class="mt-4 w-full bg-red-600 py-2 rounded text-white font-semibold">
                        Play Now
                    </button>

                    <!-- Button Add to Watchlist -->
                    {{-- @php
                    $isInWatchlist = auth()->check() && auth()->user()->savedMovies()->where('movie_id', $movie['id'])->exists();
                    @endphp
                    <button data-movie-id="{{ $movie['id'] }}" 
                    class="watchlist-btn mt-4 w-full {{ $isInWatchlist ? 'bg-gray-600' : 'bg-blue-600' }} py-2 rounded text-white font-semibold">
                    <span class="watchlist-text">{{ $isInWatchlist ? 'In Watchlist' : 'Add to Watchlist' }}</span>
                    </button> --}}

                    
                    <!-- Modal Trailer -->
                    <div x-show="showTrailer" x-data="{ trailerSrc: 'https://www.youtube.com/embed/{{ $trailerKey }}' }"
                        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50" x-cloak>
                        <div class="bg-gray-900 p-6 rounded-lg shadow-lg max-w-2xl w-full relative">
                            <!-- Tombol Close -->
                            <button @click="showTrailer = false; trailerSrc = ''" 
                                class="absolute top-2 right-2 text-white text-2xl">
                                &times;
                            </button>
                            @if (!empty($trailerKey))
                                <iframe class="w-full h-64 md:h-96 rounded-lg" 
                                    x-bind:src="trailerSrc"
                                    frameborder="0" allowfullscreen>
                                </iframe>
                            @else
                                <p class="text-center text-white">Trailer tidak tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Movie Details -->
                <div class="md:col-span-2">
                    <h1 class="text-4xl font-bold">{{ $movie['title'] }}</h1>
                    <p class="mt-4 text-lg">{{ $movie['overview'] }}</p>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-xl font-semibold">Release Date</h2>
                            <p class="mt-2">{{ $movie['release_date'] }}</p>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">Ratings</h2>
                            <p class="mt-2">IMDb: {{ number_format($movie['vote_average'], 1) }} / 10</p>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">Genres</h2>
                            <p class="mt-2">
                                @if(is_array($movie['genres']) && count($movie['genres']) > 0)
                                    {{ implode(', ', array_column($movie['genres'], 'name')) }}
                                @else
                                    Tidak ada genre yang tersedia.
                                @endif
                            </p>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">Available Languages</h2>
                            <p class="mt-2">English, Hindi, Tamil, Telugu, Kannada</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cast Section -->
            <div class="mt-8">
                <h2 class="text-2xl font-semibold">Cast</h2>
                
                <div class="relative mt-4">
                    <div id="castCarousel" class="flex gap-4 overflow-x-auto scrollbar-hide p-2">
                        @foreach ($cast as $actor)
                        <a href="{{ route('people.details', ['personId' => $actor['id']]) }}" class="flex flex-col items-center min-w-[100px]">
                            <div class="w-20 h-20 bg-gray-800 rounded-full overflow-hidden">
                                <img src="https://image.tmdb.org/t/p/w200/{{ $actor['profile_path'] ?? 'default.jpg' }}" 
                                    alt="{{ $actor['name'] }}" class="w-full h-full object-cover">
                            </div>
                            <p class="mt-2 text-sm text-center w-20 truncate">{{ $actor['name'] }}</p>
                        </a>
                        @endforeach
                    
                    </div>
                    
                    @if (count($cast) > 10)
                        <button id="prevBtn" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white p-2 rounded-full">&#9664;</button>
                        <button id="nextBtn" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white p-2 rounded-full">&#9654;</button>
                    @endif
                </div>
            </div>
            {{-- -------REVIEW FILM------------ --}}
            <div class="mt-8">
                <h2 class="text-2xl font-semibold">Reviews</h2>
                <div class="flex justify-end">
                    <button onclick="toggleReviewForm()" class="mt-4 bg-red-600 px-4 py-2 text-white rounded">
                        Add Your Review
                    </button>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <button id="prevReviewBtn" class="bg-gray-800 text-white p-2 rounded-full">&#9664;</button>
                    <div id="reviews-container" class="flex gap-4 overflow-x-auto scrollbar-hide p-2">
                        {{-- Review items will be injected here --}}
                    </div>
                    <button id="nextReviewBtn" class="bg-gray-800 text-white p-2 rounded-full">&#9654;</button>
                </div>
            </div>
            
            <div id="review-form" style="display: none;" class="mt-4 bg-gray-800 p-4 rounded shadow-lg relative">
                <button onclick="toggleReviewForm()" class="absolute top-2 right-2 bg-gray-700 text-white p-2 rounded-full">✖</button>
                <form id="review-submit-form" method="POST">
                    @csrf
                    <label for="rating" class="block text-white font-semibold">Rating:</label>
                    <select name="rating" id="review-rating" class="w-full p-2 rounded bg-gray-900 text-white">
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} ★</option>
                        @endfor
                    </select>
                        <label for="review" class="block text-white mt-4 font-semibold">Your Review:</label>
                        <textarea name="review" id="review-text" class="w-full p-2 rounded bg-gray-900 text-white" required></textarea>
                        <button type="submit" class="mt-2 w-full bg-green-600 py-2 rounded text-white">Submit Review</button>
                    </form>
                </div>
                
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let reviewContainer = document.getElementById("reviews-container");
                                let prevReviewBtn = document.getElementById("prevReviewBtn");
                                let nextReviewBtn = document.getElementById("nextReviewBtn");
                                
                                prevReviewBtn.addEventListener("click", function() {
                                reviewContainer.scrollBy({ left: -300, behavior: "smooth" });
                                });

                                nextReviewBtn.addEventListener("click", function() {
                                reviewContainer.scrollBy({ left: 300, behavior: "smooth" });
                            });

                                function fetchReviews() {
                                    fetch("{{ route('reviews.index', $movie['id']) }}")
                                        .then(response => response.json())
                                        .then(data => {
                                            reviewContainer.innerHTML = "";
                        
                                            if (data.length > 0) {
                                                data.forEach(review => {
                                                    let userPhoto = review.user.photo ? review.user.photo : "/default-avatar.png"; // Default jika kosong
                                                    let deleteButton = "";
                        
                                                    // Cek apakah user yang login adalah pemilik review
                                                    @auth
                                                        if (review.user_id === {{ auth()->id() }}) {
                                                            deleteButton = `
                                                                <button onclick="deleteReview(${review.id})" 
                                                                    class="mt-2 bg-red-600 text-white px-3 py-1 rounded">
                                                                    Delete
                                                                </button>`;
                                                        }
                                                    @endauth
                        
                                                    reviewContainer.innerHTML += `
                                                        <div class="bg-gray-900 p-4 rounded-lg shadow-md w-64 min-w-[250px]">
                                                            <div class="flex items-center mb-2">
                                                                <img src="${userPhoto}" alt="User Photo" class="w-10 h-10 rounded-full bg-gray-700">
                                                                <p class="font-bold ml-3">${review.user.name}</p>
                                                            </div>
                                                            <p class="text-yellow-400 text-lg">${'★'.repeat(review.rating)}</p>
                                                            <p class="mt-2">${review.review}</p>
                                                            <small class="text-gray-500 block mt-2">${new Date(review.created_at).toLocaleString()}</small>
                                                            ${deleteButton}
                                                        </div>`;
                                                });
                                            } else {
                                                reviewContainer.innerHTML = "<p class='text-gray-400'>No reviews yet. Be the first to review!</p>";
                                            }
                                        })
                                        .catch(error => {
                                            console.error("Error fetching reviews:", error);
                                            reviewContainer.innerHTML = "<p class='text-red-500'>Error loading reviews.</p>";
                                        });
                                }
                        
                                fetchReviews();
                        
                                document.getElementById("review-submit-form").addEventListener("submit", function (event) {
                                    event.preventDefault();
                                    let formData = new FormData(this);
                                    fetch("{{ route('reviews.store', $movie['id']) }}", {
                                        method: "POST",
                                        body: formData,
                                        headers: { "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value }
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                fetchReviews();
                                                document.getElementById("review-text").value = "";
                                                alert("Review added successfully!");
                                            } else {
                                                alert("Failed to add review.");
                                            }
                                        })
                                        .catch(error => console.error("Error submitting review:", error));
                                });
                        
                                //hapus repiew
                                window.deleteReview = function (reviewId) {
                                    if (!confirm("Are you sure you want to delete this review?")) return;
                        
                                    fetch("{{ route('reviews.destroy', '') }}/" + reviewId, {
                                        method: "DELETE",
                                        headers: {
                                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                                            "Content-Type": "application/json"
                                        }
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                fetchReviews();
                                                alert("Review deleted successfully!");
                                            } else {
                                                alert("Failed to delete review.");
                                            }
                                        })
                                        .catch(error => console.error("Error deleting review:", error));
                                };
                            });
                        
                            function toggleReviewForm() {
                                let form = document.getElementById("review-form");
                                form.style.display = (form.style.display === "none" || form.style.display === "") ? "block" : "none";
                            }

                            document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".watchlist-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let movieId = this.getAttribute("data-movie-id");
                    let btnText = this.querySelector(".watchlist-text");
                
                    fetch("{{ url('/movies/save') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ movie_id: movieId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) {
                            this.classList.remove("bg-blue-600");
                            this.classList.add("bg-gray-600");
                            btnText.innerText = "In Watchlist";
                        }
                    })
                    .catch(error => console.error("Error:", error));
                });
            });
        });

        </script>

    </div>
</x-app-layout>
