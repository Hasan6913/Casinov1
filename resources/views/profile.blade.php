@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-lg mx-auto">
        <h2 class="text-2xl font-bold text-yellow-500 mb-4">Vaš profil</h2>
        
        <!-- Poruke -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Forma za ažuriranje podataka -->
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-300">Ime:</label>
                <input type="text" id="name" name="name" value="{{ $user->name }}" class="w-full p-2 rounded border border-gray-500 text-black" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-300">Email:</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" class="w-full p-2 rounded border border-gray-500 text-black" required>
            </div>
            <button type="submit" class="bg-yellow-500 text-black px-4 py-2 rounded hover:bg-yellow-600 transition">
                Ažuriraj podatke
            </button>
        </form>

        <!-- Forma za promjenu lozinke -->
        <h3 class="text-xl font-bold text-yellow-500 mt-6 mb-4">Promijenite lozinku</h3>
        <form action="{{ route('profile.change-password') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="current_password" class="block text-gray-300">Trenutna lozinka:</label>
                <input type="password" id="current_password" name="current_password" class="w-full p-2 rounded border border-gray-500 text-black" required>
            </div>
            <div class="mb-4">
                <label for="new_password" class="block text-gray-300">Nova lozinka:</label>
                <input type="password" id="new_password" name="new_password" class="w-full p-2 rounded border border-gray-500 text-black" required>
            </div>
            <div class="mb-4">
                <label for="new_password_confirmation" class="block text-gray-300">Potvrdite novu lozinku:</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full p-2 rounded border border-gray-500 text-black" required>
            </div>
            <button type="submit" class="bg-yellow-500 text-black px-4 py-2 rounded hover:bg-yellow-600 transition">
                Promijenite lozinku
            </button>
        </form>

        <!-- Dugme za odjavu -->
        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                Odjava
            </button>
        </form>
    </div>
</div>
@endsection
