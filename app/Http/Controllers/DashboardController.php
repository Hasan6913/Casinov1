<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Dohvatanje stanja računa ulogovanog korisnika
        $stanje = Auth::user()->stanjeRacuna->stanje ?? 0;

        // Slanje podataka u pogled
        return view('dashboard', compact('stanje'));
    }
}

