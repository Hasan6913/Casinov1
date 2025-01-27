<x-app-layout>
    <div class="p-6 bg-white shadow sm:rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Admin Panel</h2>
        <p>Dobrodošli, {{ auth()->user()->name }}!</p>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('admin.users') }}" class="p-4 bg-blue-500 text-white rounded-lg text-center">Pregled korisnika</a>
            <a href="{{ route('admin.games') }}" class="p-4 bg-green-500 text-white rounded-lg text-center">Pregled igara</a>
        </div>
    </div>
</x-app-layout>
