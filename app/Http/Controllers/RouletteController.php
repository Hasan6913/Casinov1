<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouletteController extends Controller
{
    public function play(Request $request)
    {
        // Validacija podataka
        $request->validate([
            'chip' => 'required|numeric',
            'isWin' => 'required|boolean',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Korisnik nije prijavljen.'], 403);
        }

        $stanjeRacuna = $user->stanjeRacuna;

        if (!$stanjeRacuna) {
            return response()->json(['error' => 'Nema stanja na računu.'], 403);
        }

        // Provera da li ima dovoljno sredstava
        if ($stanjeRacuna->stanje < $request->chip) {
            return response()->json(['error' => 'Nema dovoljno sredstava.'], 400);
        }

        // Ažuriranje stanja na računu
        if ($request->isWin) {
            $stanjeRacuna->stanje += $request->chip * 35; // Dobitak
        } else {
            $stanjeRacuna->stanje -= $request->chip; // Gubitak
        }

        $stanjeRacuna->save();

        return response()->json(['balance' => number_format($stanjeRacuna->stanje, 2)]);
    }
}

