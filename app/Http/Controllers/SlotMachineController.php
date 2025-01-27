<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SlotMachineController extends Controller
{
    // Prikazuje stranicu slot mašine
    public function index()
    {
        $stanje = DB::table('stanje_racuna')
            ->where('user_id', Auth::id())
            ->value('stanje');
    
        return view('slot-machine', compact('stanje'));
    }
    

    // Obrada vrtnje slot mašine
    public function spin(Request $request)
    {
        $userId = Auth::id();
        $chip = $request->input('chip'); // Dobija izabrani čip (1€, 3€, 5€)

        // Provjerava trenutno stanje korisnika
        $balance = DB::table('stanje_racuna')
            ->where('user_id', $userId)
            ->value('stanje');

        if ($balance < $chip) {
            return response()->json(['error' => 'Nemate dovoljno novca!'], 400);
        }

        // Skidanje novca
        $newBalance = $balance - $chip;

        // Simulacija slot mašine
        $symbols = ['🍒', '🍋', '🔔', '⭐', '🍉'];
        $slot1 = $symbols[array_rand($symbols)];
        $slot2 = $symbols[array_rand($symbols)];
        $slot3 = $symbols[array_rand($symbols)];

        $win = 0;

        if ($slot1 === $slot2 && $slot2 === $slot3) {
            $win = $chip * 10; // Dobitak 10x uloga
            $newBalance += $win;
        }

        // Ažuriranje stanja u bazi
        DB::table('stanje_racuna')
            ->where('user_id', $userId)
            ->update(['stanje' => $newBalance]);

        return response()->json([
            'balance' => $newBalance,
            'slots' => [$slot1, $slot2, $slot3],
            'win' => $win,
        ]);
    }
}
