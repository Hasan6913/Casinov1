<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\StanjeRacuna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        // Validacija podataka
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        // Kreiranje korisnika
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Automatsko kreiranje početnog stanja računa
        StanjeRacuna::create([
            'user_id' => $user->id,
            'stanje' => 0, // Početno stanje, može biti druga vrednost
        ]);

        return $user;
    }
}
