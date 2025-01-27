<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Naše Igre</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-900 text-gray-100">

    <!-- Navigacija -->
    <nav class="bg-gray-800 py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-3xl font-bold text-yellow-500">GAMBLE</a>
            <div>
                <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white px-4">Početna</a>
                <a href="{{ route('games') }}" class="text-yellow-500 hover:text-white px-4">Igre</a>
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-4">Prijava</a>
                <a href="{{ route('register') }}" class="text-yellow-500 hover:bg-yellow-500 hover:text-black px-4 py-2 rounded-lg border border-yellow-500">Registracija</a>
            </div>
        </div>
    </nav>

    <!-- Hero sekcija -->
    <section class="bg-gray-800 py-16">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl font-extrabold text-yellow-500 mb-4">Naše igre</h1>
            <p class="text-lg text-gray-300">Upoznajte se sa najboljim igrama koje nudimo!</p>
        </div>
    </section>

    <!-- Sekcija za igre -->
    <section class="py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-yellow-500 mb-8">Igrajte i uživajte</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Prva igra -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <img src="{{ asset('images/slots-icon.png') }}" alt="Slot Machine" class="h-48 w-full object-cover rounded-md">
                    <h3 class="text-xl font-bold mt-4">Slot Machine</h3>
                    <p class="text-gray-400 mt-2">Popularna slot igra.</p>
                    <a href="{{ route('games.slot') }}" class="mt-4 inline-block bg-yellow-500 text-black px-4 py-2 rounded-lg font-bold hover:bg-yellow-600 transition">Igraj sada</a>
                </div>
                <!-- Druga igra -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <img src="{{ asset('images/blackjack-icon.png') }}" alt="Blackjack" class="h-48 w-full object-cover rounded-md">
                    <h3 class="text-xl font-bold mt-4">Blackjack</h3>
                    <p class="text-gray-400 mt-2">Klasična kartaška igra.</p>
                    <a href="{{ route('games.blackjack') }}" class="mt-4 inline-block bg-yellow-500 text-black px-4 py-2 rounded-lg font-bold hover:bg-yellow-600 transition">Igraj sada</a>
                </div>
                <!-- Treća igra -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <img src="{{ asset('images/roulette-icon.png') }}" alt="Roulette" class="h-48 w-full object-cover rounded-md">
                    <h3 class="text-xl font-bold mt-4">Roulette</h3>
                    <p class="text-gray-400 mt-2">Uzbudljiva igra ruleta.</p>
                    <a href="{{ route('games.roulette') }}" class="mt-4 inline-block bg-yellow-500 text-black px-4 py-2 rounded-lg font-bold hover:bg-yellow-600 transition">Igraj sada</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 py-4">
        <div class="container mx-auto text-center text-gray-500">
            <p>&copy; 2025 GAMBLE. Sva prava zadržana.</p>
        </div>
    </footer>
</body>
</html>
