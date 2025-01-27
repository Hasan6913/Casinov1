@extends('layouts.app')

@section('content')
<body class="bg-gray-900 text-white min-h-screen flex flex-col items-center justify-center">
<div class="container mx-auto text-center py-8">
    <h1 class="text-4xl text-yellow-500 font-bold mb-6">BLACKJACK</h1>
    <h2 class="text-2xl text-gray-300 mb-6">Stanje računa: <span id="balance" class="text-yellow-400 font-bold">{{ number_format($stanje, 2) }}€</span></h2>
    
    <!-- Čipovi za igru -->
    <div class="mb-8">
        <button id="chip-1" data-value="1" class="chip w-16 h-16 bg-green-500 text-white rounded-full hover:bg-green-600">1€</button>
        <button id="chip-3" data-value="3" class="chip w-16 h-16 bg-blue-500 text-white rounded-full hover:bg-blue-600">3€</button>
        <button id="chip-5" data-value="5" class="chip w-16 h-16 bg-red-500 text-white rounded-full hover:bg-red-600">5€</button>
    </div>

    <!-- Dugme za početak igre -->
    <button id="start-game-btn" class="bg-yellow-500 hover:bg-orange-600 text-black font-bold py-2 px-4 rounded-lg hidden">Počni igru</button>
</div>

<div class="w-full max-w-md mx-auto bg-gray-800 rounded-lg shadow-md p-6">
    
    <h1 class="text-2xl font-bold text-center text-yellow-500 mb-4">Blackjack</h1>
    
    <!-- Igrac -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-yellow-400">Tvoje karte</h2>
        <div id="player-cards" class="flex gap-2 mt-2"></div>
        <p id="player-score" class="text-gray-300 mt-2">Rezultat: 0</p>
    </div>

    <!-- Diler -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-yellow-400">Dilerove karte</h2>
        <div id="dealer-cards" class="flex gap-2 mt-2"></div>
        <p id="dealer-score" class="text-gray-300 mt-2">Rezultat: 0</p>
    </div>

    <!-- Kontrole -->
    <div class="flex justify-between mt-4">
        <button id="hit-btn" class="bg-yellow-500 hover:bg-orange-600 text-black font-bold py-2 px-4 rounded-lg" disabled>Hit</button>
        <button id="stand-btn" class="bg-yellow-500 hover:bg-orange-600 text-black font-bold py-2 px-4 rounded-lg" disabled>Stand</button>
    </div>

    <p id="message" class="text-center text-yellow-400 font-bold mt-4"></p>
</div>

<script>
    let deck = [];
    let playerHand = [];
    let dealerHand = [];
    let playerScore = 0;
    let dealerScore = 0;
    let chipValue = 0; // Početna vrednost čipa

    const playerCardsDiv = document.getElementById('player-cards');
    const dealerCardsDiv = document.getElementById('dealer-cards');
    const playerScoreDiv = document.getElementById('player-score');
    const dealerScoreDiv = document.getElementById('dealer-score');
    const messageDiv = document.getElementById('message');
    const hitBtn = document.getElementById('hit-btn');
    const standBtn = document.getElementById('stand-btn');
    const balanceDiv = document.getElementById('balance');
    const startGameBtn = document.getElementById('start-game-btn'); // Dugme za početak igre

    // Odabir čipa
    document.querySelectorAll('.chip').forEach(chip => {
        chip.addEventListener('click', () => {
            chipValue = parseInt(chip.getAttribute('data-value'));
            alert(`Odabrali ste čip od ${chipValue}€`);

            // Prikazuje dugme za početak igre
            startGameBtn.classList.remove('hidden');
        });
    });

    // Početak igre
    startGameBtn.addEventListener('click', async () => {
        if (chipValue === 0) {
            alert('Morate odabrati čip!');
            return;
        }

        const response = await fetch('/blackjack/start', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ chip: chipValue })
        });

        const data = await response.json();

        if (data.error) {
            alert(data.error);
            return;
        }

        createDeck();
        playerHand = [];
        dealerHand = [];
        playerCardsDiv.innerHTML = '';
        dealerCardsDiv.innerHTML = '';
        messageDiv.textContent = '';
        playerScore = dealerScore = 0;
        balanceDiv.textContent = `Stanje računa: €${data.balance}`;

        dealCard(playerHand, playerCardsDiv);
        dealCard(playerHand, playerCardsDiv);
        dealCard(dealerHand, dealerCardsDiv);

        updateScores();
        toggleButtons(false);
        startGameBtn.classList.add('hidden'); // Sakrij dugme nakon početka igre
    });

    function createDeck() {
        const suits = ['♠', '♥', '♦', '♣'];
        const values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
        deck = [];
        for (let suit of suits) {
            for (let value of values) {
                deck.push({ value, suit });
            }
        }
        deck = shuffle(deck);
    }

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    function calculateScore(hand) {
        let score = 0;
        let aces = 0;
        for (let card of hand) {
            if (['J', 'Q', 'K'].includes(card.value)) {
                score += 10;
            } else if (card.value === 'A') {
                score += 11;
                aces++;
            } else {
                score += parseInt(card.value);
            }
        }
        while (score > 21 && aces > 0) {
            score -= 10;
            aces--;
        }
        return score;
    }

    function dealCard(hand, div) {
        const card = deck.pop();
        hand.push(card);
        const cardDiv = document.createElement('div');
        cardDiv.textContent = `${card.value}${card.suit}`;
        cardDiv.className = "bg-white text-black font-bold py-2 px-3 rounded shadow";
        div.appendChild(cardDiv);
    }

    function updateScores() {
        playerScore = calculateScore(playerHand);
        dealerScore = calculateScore(dealerHand);

        playerScoreDiv.textContent = `Rezultat: ${playerScore}`;
        dealerScoreDiv.textContent = `Rezultat: ${dealerScore}`;
    }

    async function endGame() {
        toggleButtons(true);

        while (dealerScore < 17) {
            dealCard(dealerHand, dealerCardsDiv);
            dealerScore = calculateScore(dealerHand);
            dealerScoreDiv.textContent = `Rezultat: ${dealerScore}`;
        }

        let winAmount = 0;

        if (playerScore > 21) {
            messageDiv.textContent = 'Izgubio si! Prešao si 21.';
            winAmount = -chipValue;
        } else if (dealerScore > 21 || playerScore > dealerScore) {
            messageDiv.textContent = 'Pobedio si!';
            winAmount = chipValue * 2; // Duplira se čip ako je pobedio
        } else if (playerScore === dealerScore) {
            messageDiv.textContent = 'Nerešeno!';
        } else {
            messageDiv.textContent = 'Izgubio si!';
            winAmount = -chipValue;
        }

        const response = await fetch('/blackjack/end', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ winAmount })
        });

        const data = await response.json();
        balanceDiv.textContent = `Stanje računa: €${data.balance}`;

        // Popup poruka za odabir čipa
        alert('Odaberite čip za sledeću igru!');
    }

    function toggleButtons(disable) {
        hitBtn.disabled = standBtn.disabled = disable;
    }

    hitBtn.addEventListener('click', () => {
        dealCard(playerHand, playerCardsDiv);
        updateScores();

        if (playerScore > 21) {
            messageDiv.textContent = 'Izgubio si! Prešao si 21.';
            endGame();
        }
    });

    standBtn.addEventListener('click', () => endGame());
</script>
</body>
@endsection
