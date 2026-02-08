<x-app-layout>
    @section('title', 'Popular People')

    <div class="container mx-auto p-4 bg-black text-white">
        <h1 class="text-4xl font-bold text-center mb-8">Popular Actor</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($people['results'] as $person)
                <a href="{{ route('people.details', $person['id']) }}" class="block bg-gray-800 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                    <img class="w-full h-72 object-cover" src="https://image.tmdb.org/t/p/w500{{ $person['profile_path'] }}" alt="{{ $person['name'] }}">
                    <div class="p-4 text-center">
                        <h2 class="text-lg font-semibold text-White-500">{{ $person['name'] }}</h2>
                        <p class="text-sm text-gray-400">Known for: {{ $person['known_for_department'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center mt-8 space-x-4">
            <p class="text-lg">Page {{ $people['page'] }} of {{ $people['total_pages'] }}</p>

            @if ($people['page'] > 1)
                <a href="{{ route('people', ['page' => $people['page'] - 1]) }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">Previous</a>
            @endif

            @if ($people['page'] < $people['total_pages'])
                <a href="{{ route('people', ['page' => $people['page'] + 1]) }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">Next</a>
            @endif
        </div>
    </div>
</x-app-layout>
