<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-300">
        <!-- Navigacija -->
        <nav class="bg-gray-800 py-2">
    <div class="container mx-auto flex justify-between items-center">
        <a href="#" class="text-3xl font-bold text-yellow-500">GAMBLE</a>
        <div class="flex items-center space-x-4">
            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white hover:bg-yellow-500 px-4 py-2 rounded">Početna</a>
            <a href="{{ route('games') }}" class="text-gray-300 hover:text-white hover:bg-yellow-500 px-4 py-2 rounded">Igre</a>
            <span class="text-gray-300">Stanje računa: <span class="text-yellow-400 font-bold">{{ number_format($stanje, 2) }}€</span></span>
            <button id="add-money-btn" class="btn btn-primary btn-sm font-bold bg-yellow-500 px-1 rounded">+</button>
            
            <!-- Dropdown za korisnički profil -->
            <div class="relative">
                <button class="flex items-center text-sm font-medium text-gray-300 hover:text-white focus:outline-none" id="profileDropdown">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover">
                    <span class="ml-2">{{ Auth::user()->name }}</span>
                    <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-48 bg-gray-800 text-gray-300 rounded shadow-lg z-50" id="profileMenu">
                    <div class="px-4 py-2">
                        <p class="font-bold">{{ Auth::user()->name }}</p>
                        <p class="text-sm">{{ Auth::user()->email }}</p>
                    </div>
                    <hr class="my-1">
                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">Uredi profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">
                            Odjavi se
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
  <!-- Poruka o uspjehu -->
  @if(session('success'))
    <div id="success-message" class="bg-green-500 text-white p-4 rounded mb-4 container mx-auto max-w-lg relative">
        <button id="close-success-btn" class="absolute top-2 right-2 text-white font-bold">X</button>
        {{ session('success') }}
    </div>
@endif


<!-- Forma za dodavanje novca -->
<section id="add-money-form" style="display: none;" class="container mx-auto my-8">
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-lg mx-auto">
        <h2 class="text-xl font-bold text-yellow-500 mb-4">Dodajte novac na vaš račun</h2>
        <form action="{{ route('add.money') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="amount" class="block text-gray-300">Unesite iznos:</label>
                <input type="number" id="amount" name="amount" class="w-full p-2 rounded border border-gray-500 text-black" required>
            </div>
            <button type="submit" class="bg-yellow-500 text-black px-4 py-2 rounded hover:bg-yellow-600 transition">
                Dodaj novac
            </button>
        </form>
    </div>
</section>


    <div>
        @yield('content')
    </div>

    <script>
        // Dropdown za korisnički profil
        const profileDropdown = document.getElementById('profileDropdown');
        const profileMenu = document.getElementById('profileMenu');

        profileDropdown.addEventListener('click', () => {
            profileMenu.classList.toggle('hidden');
        });

        // Ostale skripte
        document.getElementById('add-money-btn').addEventListener('click', function () {
            const form = document.getElementById('add-money-form');
            form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
            if (form.style.display === 'none') {
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    successMessage.style.display = 'block';
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 2000);
                }
            }
        });

        const closeSuccessBtn = document.getElementById('close-success-btn');
        if (closeSuccessBtn) {
            closeSuccessBtn.addEventListener('click', function () {
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            });
        }
    </script>

</body>
</html>
