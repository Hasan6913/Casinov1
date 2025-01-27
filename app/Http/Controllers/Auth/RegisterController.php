<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StanjeRacuna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Prikazuje formu za registraciju (osveži ili kreiraj ovu stranicu ako je nema)
    }

    public function register(Request $request)
    {
        // Validacija podataka
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Kreiraj korisnika
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Kreiraj početno stanje računa
        StanjeRacuna::create([
            'user_id' => $user->id,
            'stanje' => 0, // Početno stanje (možete promeniti)
        ]);

        // Prijavi korisnika
        Auth::login($user);

        return redirect('/'); // Preusmeri korisnika nakon registracije
    }
}

