@extends('layouts.app')

@section('content')

<div class="container mx-auto py-8">
    <h1 class="text-center text-3xl font-bold text-yellow-500 mb-6">Naše igre</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($games as $game)
            <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <img src="{{ $game['image'] }}" alt="{{ $game['name'] }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-yellow-500 mb-2">{{ $game['name'] }}</h2>
                    <p class="text-gray-300 mb-4">{{ $game['description'] }}</p>
                    <a href="{{ route($game['route']) }}" 
                       class="block text-center font-bold text-gray-900 bg-yellow-500 py-2 px-4 rounded-lg hover:bg-orange-600 transition-all duration-300">
                        Igraj sada
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
