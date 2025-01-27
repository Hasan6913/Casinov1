@extends('layouts.app')

@section('content')
<div class="container mx-auto text-center py-8">
    <h1 class="text-4xl text-yellow-500 font-bold mb-6">Slot Machine</h1>
    <h2 class="text-2xl text-gray-300 mb-6">Stanje računa: <span id="balance" class="text-yellow-400 font-bold">{{ number_format($stanje, 2) }}€</span></h2>
    <h3 class="text-xl text-gray-300 mb-4">Izaberite čip:</h3>
    <div class="flex justify-center space-x-4 mb-6">
        <button class="btn-chip bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2 px-4 rounded" data-value="1">1€</button>
        <button class="btn-chip bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2 px-4 rounded" data-value="3">3€</button>
        <button class="btn-chip bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2 px-4 rounded" data-value="5">5€</button>
    </div>
    <button id="spin-btn" class="btn-spin bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full disabled:opacity-50" disabled>Zavrti</button>
    <div class="flex justify-center space-x-6 my-6">
        <div class="slot text-4xl bg-gray-200 py-4 px-6 rounded-lg">🍒</div>
        <div class="slot text-4xl bg-gray-200 py-4 px-6 rounded-lg">🍒</div>
        <div class="slot text-4xl bg-gray-200 py-4 px-6 rounded-lg">🍒</div>
    </div>
    <h3 id="result" class="text-lg text-gray-300 mt-6"></h3>
</div>

<script>
    let selectedChip = 0;

    // Izbor čipa
    document.querySelectorAll('.btn-chip').forEach(chip => {
        chip.addEventListener('click', function () {
            selectedChip = parseInt(this.dataset.value);
            document.getElementById('spin-btn').disabled = false;
            document.getElementById('result').textContent = `Izabrali ste čip od ${selectedChip}€`;
        });
    });

    // Vrtnja slot mašine
    document.getElementById('spin-btn').addEventListener('click', function () {
        fetch("{{ route('slot.machine.spin') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ chip: selectedChip })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('result').textContent = data.error;
                return;
            }

            document.getElementById('balance').textContent = data.balance.toFixed(2) + '€';
            const slots = document.querySelectorAll('.slot');
            slots[0].textContent = data.slots[0];
            slots[1].textContent = data.slots[1];
            slots[2].textContent = data.slots[2];

            if (data.win > 0) {
                document.getElementById('result').textContent = `Čestitamo! Osvojili ste ${data.win.toFixed(2)}€`;
            } else {
                document.getElementById('result').textContent = 'Nažalost, pokušajte ponovo!';
            }
        });
    });
</script>
@endsection
