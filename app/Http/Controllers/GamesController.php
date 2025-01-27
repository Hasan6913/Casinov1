<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GamesController extends Controller
{
    public function index()
    {
        $games = [
            ['name' => 'Slot Machine', 'image' => '/images/slot1.jpeg', 'description' => 'Popularna slot igra.', 'route' => 'slot.machine'],
            ['name' => 'Blackjack', 'image' => '/images/blackjack.jpg', 'description' => 'Klasična kartaška igra.', 'route' => 'games.blackjack'],
            ['name' => 'Roulette', 'image' => '/images/roulette.jpg', 'description' => 'Uzbudljiva igra ruleta.', 'route' => 'games.roulette'],
        ];

        // Dohvatanje stanja računa za trenutnog korisnika
        $stanje = auth()->check() ? auth()->user()->stanjeRacuna->stanje ?? 0 : 0;

        return view('games.index', compact('games', 'stanje'));
    }

    public function blackjack()
    {
        $stanje = auth()->check() ? auth()->user()->stanjeRacuna->stanje ?? 0 : 0; // Proveri stanje računa
    
        return view('games.blackjack', compact('stanje'));
    }
    
    public function roulette()
    {
        return view('games.roulette');
    }

    public function playRoulette(Request $request)
    {
        $user = Auth::user();
        $stanjeRacuna = $user->stanjeRacuna;

        $chip = $request->chip;
        $isWin = $request->isWin;

        if ($stanjeRacuna->stanje < $chip) {
            return response()->json(['error' => 'Nemate dovoljno novca na računu.'], 400);
        }

        // Ažuriraj stanje
        if ($isWin) {
            $stanjeRacuna->stanje += $chip;
        } else {
            $stanjeRacuna->stanje -= $chip;
        }
        $stanjeRacuna->save();

        return response()->json(['balance' => $stanjeRacuna->stanje]);
    }
}

