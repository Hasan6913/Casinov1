<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Ograničenje broja pokušaja prijave
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Autentifikacija korisnika
        Fortify::authenticateUsing(function (Request $request) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return Auth::user();
            }

            return null;
        });

        // Dodaj logiku za preusmjeravanje nakon prijave
        Fortify::redirects('login', function () {
            $user = Auth::user();
            if ($user) {
                if ($user->role === 'admin') {
                    return '/admin'; // Ruta za admin dashboard
                }
                return '/dashboard'; // Ruta za korisnički dashboard
            }
            return '/login'; // Ako nije logovan, vrati na login
        });
    }
}
