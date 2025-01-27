@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Rulet</h2>
        <p class="text-lg" id="balance">Stanje na računu: €{{ Auth::user()->stanjeRacuna->stanje }}</p>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-8">
        <!-- Odabir čipova -->
        <button id="chip-1" data-value="1" class="chip w-16 h-16 bg-green-500 text-white rounded-full hover:bg-green-600">
            1€
        </button>
        <button id="chip-3" data-value="3" class="chip w-16 h-16 bg-blue-500 text-white rounded-full hover:bg-blue-600">
            3€
        </button>
        <button id="chip-5" data-value="5" class="chip w-16 h-16 bg-red-500 text-white rounded-full hover:bg-red-600">
            5€
        </button>
    </div>

    <!-- Odabir brojeva na ruletu -->
    <div class="mb-8">
        <div class="flex flex-wrap justify-center gap-2">
            @foreach(range(0, 36) as $number)
                <button class="roulette-number w-12 h-12 rounded-full 
                    {{ $number % 2 == 0 ? 'bg-black text-white' : 'bg-red-500 text-white' }}" 
                    data-number="{{ $number }}">
                    {{ $number }}
                </button>
            @endforeach
        </div>
    </div>

    <button id="play" class="w-full bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600">Zavrti</button>
</div>

<script>
    let selectedChip = 0;
    let selectedNumber = null;

    // Odabir čipa
    document.querySelectorAll('.chip').forEach(chip => {
        chip.addEventListener('click', () => {
            selectedChip = parseInt(chip.getAttribute('data-value'));

            // Resetuj sve čipove
            document.querySelectorAll('.chip').forEach(btn => {
                btn.classList.remove('border-4', 'border-yellow-500');
            });

            // Dodaj žuti okvir oko odabranog čipa
            chip.classList.add('border-4', 'border-yellow-500');
            alert(`Odabrali ste čip od ${selectedChip}€`);
        });
    });

    // Odabir broja
    document.querySelectorAll('.roulette-number').forEach(number => {
        number.addEventListener('click', () => {
            selectedNumber = parseInt(number.getAttribute('data-number'));

            // Resetuj sve brojeve
            document.querySelectorAll('.roulette-number').forEach(btn => {
                btn.classList.remove('border-4', 'border-yellow-500');
            });

            // Dodaj žuti okvir oko odabranog broja
            number.classList.add('border-4', 'border-yellow-500');
        });
    });

    // Spin dugme
    document.getElementById('play').addEventListener('click', async () => {
        if (selectedChip === 0 || selectedNumber === null) {
            alert('Morate odabrati čip i broj!');
            return;
        }

        // Simulacija ruleta
        const winningNumber = Math.floor(Math.random() * 37);
        const isWin = winningNumber === selectedNumber;

        let resultMessage = isWin 
            ? `Pobijedili ste! Pobednički broj je: ${winningNumber}.`
            : `Izgubili ste. Pobednički broj je: ${winningNumber}.`;

        // Ažuriraj stanje na serveru
        const response = await fetch('/roulette/play', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                chip: selectedChip,
                isWin: isWin
            })
        });

        const data = await response.json();
        document.getElementById('balance').innerText = `Stanje na računu: €${data.balance}`;

        alert(resultMessage);
    });
</script>
@endsection
