<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StanjeRacuna extends Model
{
    use HasFactory;

    protected $table = 'stanje_racuna';

    protected $fillable = ['user_id', 'stanje'];

    // Veza s korisnikom
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

