<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlackjackController extends Controller
{
    public function start(Request $request)
    {
        $userId = Auth::id();
        $chipValue = $request->input('chip', 5); // Korisnik odabire čip

        // Dohvati trenutno stanje korisnika iz baze
        $balance = DB::table('stanje_racuna')
            ->where('user_id', $userId)
            ->value('stanje');

        // Provjera da li korisnik ima dovoljno sredstava
        if ($balance < $chipValue) {
            return response()->json(['error' => 'Nemate dovoljno sredstava za novu rundu.'], 400);
        }

        // Skidanje čipa sa računa
        $newBalance = $balance - $chipValue;
        DB::table('stanje_racuna')
            ->where('user_id', $userId)
            ->update(['stanje' => $newBalance]);

        // Započni igru (logika igre bi trebalo da se nalazi ovde)
        // Npr. simulacija da li je korisnik pobedio (ovde samo za primer)
        $winAmount = 0;  // Ako korisnik pobedi, ovde bi trebalo da se postavi duplirani iznos čipa

        // Na kraju igre (pobeda/gubitak) ažuriraj stanje
        $finalBalance = $winAmount ? $newBalance + ($chipValue * 2) : $newBalance;

        DB::table('stanje_racuna')
            ->where('user_id', $userId)
            ->update(['stanje' => $finalBalance]);

        return response()->json(['balance' => $finalBalance]);
    }

    // Dodatna funkcija za završetak igre i iznos pobede/gubitka
    public function end(Request $request)
    {
        $userId = Auth::id();
        $winAmount = $request->input('winAmount', 0); // Duplirani iznos u slučaju pobede

        // Ažuriranje stanja računa
        $balance = DB::table('stanje_racuna')
            ->where('user_id', $userId)
            ->value('stanje');

        $newBalance = $balance + $winAmount;
        DB::table('stanje_racuna')
            ->where('user_id', $userId)
            ->update(['stanje' => $newBalance]);

        return response()->json(['balance' => $newBalance]);
    }
}
