<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                    <div class="flex items-center">
                <span class="text-2xl font-bold tracking-wider">GAMBLE</span>
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <a href="{{ route('dashboard') }}" 
   class="px-6 py-3 text-lg font-bold text-center text-black-300 hover:text-white hover:bg-yellow-500 transition duration-300 rounded-md flex items-center justify-end">
   Početna
</a>
            </div>

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <a href="{{ route('games') }}" 
            class="px-6 py-3 text-lg font-bold text-center text-black-300 hover:text-white hover:bg-yellow-500 transition duration-300 rounded-md flex items-center justify-end">
   Igre
</a>
            </div>
        </div>
    </div>
</nav>
