<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(), // Ensure uniqueness
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // All users will have the same password
            'remember_token' => \Str::random(10),
        ];
    }
    
    
}

