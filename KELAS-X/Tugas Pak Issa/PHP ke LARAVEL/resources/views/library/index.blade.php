@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'epic-dark': '#121212',
                        'epic-gray': '#2a2a2a',
                    }
                }
            }
        }
    </script>
    <style>
        .game-card { transition: transform 0.2s; }
        .game-card:hover { transform: translateY(-4px); }
        .game-image { transition: opacity 0.3s; }
        .game-card:hover .game-image { opacity: 0.7; }
    </style>
</head>
<body class="bg-epic-dark text-white font-sans">
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Library</h1>

            <!-- Search and Sort Controls -->
            <div class="flex items-center space-x-4">
                <form action="{{ route('library.index') }}" method="GET" class="flex space-x-2">
                    <select name="sort" onchange="this.form.submit()"
                            class="bg-epic-gray px-4 py-2 rounded hover:bg-opacity-80 transition">
                        {{-- <option value="recent" {{ $sort === 'recent' ? 'selected' : '' }}>Recently Purchased</option>
                        <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Name</option> --}}
                    </select>
                    {{-- <input type="text" name="search" value="{{ $search }}"
                           placeholder="Search games"
                           class="bg-epic-gray px-4 py-2 rounded w-48 focus:ring-2 focus:ring-blue-500 transition"> --}}
                </form>
            </div>
        </div>
{{--
        <!-- Filter Buttons -->
        <div class="flex space-x-4 mb-6">
            <a href="{{ route('library.index', ['filter' => 'all']) }}"
               class="{{ $filter === 'all' ? 'bg-blue-600' : 'bg-epic-gray' }} text-white px-4 py-2 rounded transition hover:opacity-90">
                All
            </a>
            <a href="{{ route('library.index', ['filter' => 'favorites']) }}"
               class="{{ $filter === 'favorites' ? 'bg-blue-600' : 'bg-epic-gray' }} text-white px-4 py-2 rounded transition hover:opacity-90">
                Favorites
            </a>
        </div> --}}

        <!-- Games Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if ($games->isEmpty())
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-400">No games found in your library.</p>
                </div>
            @else
                @foreach ($games as $game)
                    <div class="game-card bg-epic-gray rounded-lg overflow-hidden relative shadow-lg">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50"></div>
                        <img src="{{ $game->product->images->first()->image_url ?? asset('images/default-image.jpg') }}"
                        alt="{{ $game->product->name }}"
                        class="game-image w-full h-64 object-cover">

                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-bold truncate">{{ $game->product->name }}</h2>
                                <form method="POST" action="{{ route('library.toggleFavorite') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="game_id" value="{{ $game->product->id }}">
                                    <button type="submit" class="text-yellow-400 text-2xl hover:scale-110 transition">
                                        {{ $game->is_favorite ? '★' : '☆' }}
                                    </button>
                                </form>
                            </div>

                            <div class="mt-2 flex justify-between items-center">
                                <form method="POST" action="#" class="inline">
                                    @csrf
                                    <input type="hidden" name="game_id" value="{{ $game->product->id }}">
                                    <button type="submit"
                                            class="{{ $game->install_status === 'installed' ? 'bg-green-600' : 'bg-blue-600' }}
                                                   text-white px-4 py-2 rounded hover:opacity-90 transition">
                                        {{ $game->install_status === 'installed' ? 'Installed' : 'Install' }}
                                    </button>
                                </form>
                                <span class="text-sm text-gray-400">
                                    {{ $game->purchase_date->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Games Count -->
        {{-- <div class="mt-6 text-gray-400">
            Showing {{ $games->count() }} of {{ $totalGames }} games
        </div> --}}
    </div>

    <!-- Shop Games Button -->
    @if ($games->isNotEmpty())
        <div class="fixed right-8 bottom-8 bg-epic-gray rounded-lg p-4 shadow-lg hover:transform hover:-translate-y-1 transition">
            <h3 class="text-lg font-semibold mb-2">Shop Games & Mods</h3>
            <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-2 rounded block text-center hover:bg-blue-700 transition">
                Browse
            </a>
        </div>
    @endif
</body>
</html>
@endsection
