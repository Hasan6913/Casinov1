<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function addMoney(Request $request)
    {
        // Validacija ulaznih podataka
        $request->validate([
            'amount' => 'required|numeric|min:1', // Minimalni iznos koji možeš dodati je 1
        ]);

        // Dohvati trenutnog korisnika
        $user = Auth::user();

        // Dodaj novac na račun korisnika
        $user->stanjeRacuna->stanje += $request->input('amount');
        $user->stanjeRacuna->save();

        // Preusmeri nazad sa porukom o uspehu
        return redirect()->back()->with('success', 'Novac je uspešno dodat na vaš račun!');
    }
}
